<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Position;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['primaryAssignment.branch', 'primaryAssignment.position'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        // Filter by branch
        if ($request->filled('branch_id')) {
            $query->whereHas('activeAssignments', function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('employee_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(15);
        $branches = Branch::active()->get();

        return view('employees.index', compact('employees', 'branches'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $branches = Branch::active()->get();
        $departments = Department::active()->get();
        $positions = Position::active()->get();
        $supervisors = Employee::active()
            ->whereHas('activeAssignments', function ($q) {
                $q->whereHas('position', function ($p) {
                    $p->where('level', '>=', 3); // Supervisor level and above
                });
            })
            ->get();

        return view('employees.create', compact('branches', 'departments', 'positions', 'supervisors'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_number' => 'required|string|max:20|unique:employees',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'birth_place' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'id_number' => 'nullable|string|max:30',
            'tax_number' => 'nullable|string|max:30',
            'bank_account' => 'nullable|string|max:30',
            'bank_name' => 'nullable|string|max:50',
            'hire_date' => 'required|date',
            'employment_type' => 'required|in:permanent,contract,probation,internship',
            // Initial assignment
            'branch_id' => 'required|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'supervisor_id' => 'nullable|exists:employees,id',
        ]);

        // Create employee
        $employee = Employee::create([
            ...$validated,
            'employment_status' => 'active',
            'is_active' => true,
            'created_by' => auth()->id(),
        ]);

        // Create initial assignment
        Assignment::create([
            'employee_id' => $employee->id,
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'supervisor_id' => $request->supervisor_id,
            'start_date' => $request->hire_date,
            'is_primary' => true,
            'status' => 'active',
            'created_by' => auth()->id(),
        ]);

        // Record history
        $employee->recordHistory(
            'assignment_added',
            null,
            null,
            ['branch_id' => $request->branch_id, 'position_id' => $request->position_id],
            now(),
            'Initial assignment upon hire'
        );

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $employee->load([
            'assignments.branch',
            'assignments.department',
            'assignments.position',
            'assignments.supervisor',
            'histories' => fn($q) => $q->latest()->take(10),
        ]);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $branches = Branch::active()->get();
        $departments = Department::active()->get();
        $positions = Position::active()->get();
        $supervisors = Employee::active()
            ->where('id', '!=', $employee->id)
            ->get();

        return view('employees.edit', compact('employee', 'branches', 'departments', 'positions', 'supervisors'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_number' => ['required', 'string', 'max:20', Rule::unique('employees')->ignore($employee->id)],
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('employees')->ignore($employee->id)],
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'birth_place' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'id_number' => 'nullable|string|max:30',
            'tax_number' => 'nullable|string|max:30',
            'bank_account' => 'nullable|string|max:30',
            'bank_name' => 'nullable|string|max:50',
            'employment_type' => 'required|in:permanent,contract,probation,internship',
        ]);

        // Track changes for history
        $changes = [];
        foreach ($validated as $key => $value) {
            if ($employee->{$key} !== $value) {
                $changes[$key] = [
                    'old' => $employee->{$key},
                    'new' => $value,
                ];
            }
        }

        $employee->update([
            ...$validated,
            'updated_by' => auth()->id(),
        ]);

        // Record history for significant changes
        if (!empty($changes)) {
            $employee->recordHistory(
                'profile_update',
                implode(', ', array_keys($changes)),
                array_column($changes, 'old'),
                array_column($changes, 'new'),
                now()
            );
        }

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee (soft delete).
     */
    public function destroy(Employee $employee)
    {
        $employee->update([
            'employment_status' => 'terminated',
            'termination_date' => now(),
            'is_active' => false,
            'updated_by' => auth()->id(),
        ]);

        // End all active assignments
        $employee->activeAssignments()->each(function ($assignment) {
            $assignment->end(now(), 'Employment terminated');
        });

        $employee->recordHistory(
            'termination',
            null,
            ['status' => 'active'],
            ['status' => 'terminated'],
            now()
        );

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee terminated successfully.');
    }
}
