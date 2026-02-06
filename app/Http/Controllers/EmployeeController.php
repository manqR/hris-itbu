<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Organization;
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
        $query = Employee::with(['primaryAssignment.organization', 'primaryAssignment.position'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        // Filter by organization
        if ($request->filled('organization_id')) {
            $query->whereHas('activeAssignments', function ($q) use ($request) {
                $q->where('organization_id', $request->organization_id);
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
        $organizations = Organization::active()->get();

        return view('employees.index', compact('employees', 'organizations'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $organizations = Organization::active()->get();
        $departments = Department::active()->get();
        $positions = Position::active()->get();
        $supervisors = Employee::active()
            ->whereHas('activeAssignments', function ($q) {
                $q->whereHas('position', function ($p) {
                    $p->where('level', '>=', 3); // Supervisor level and above
                });
            })
            ->get();

        return view('employees.create', compact('organizations', 'departments', 'positions', 'supervisors'));
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
            'organization_ids' => 'required|array|min:1',
            'organization_ids.*' => 'exists:organizations,id',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'supervisor_id' => 'nullable|exists:employees,id',
            // Login Access
            'create_user_account' => 'nullable|boolean',
            'password' => 'nullable|required_if:create_user_account,1|string|min:8|confirmed',
        ]);

        // Create employee with password if account creation is requested
        $employeeData = [
            ...$validated,
            'employment_status' => 'active',
            'is_active' => true,
        ];

        if ($request->boolean('create_user_account') && $request->filled('password')) {
            $employeeData['password'] = $request->password; // Will be hashed by model cast
        }

        $employee = Employee::create($employeeData);

        // Create assignments for all selected organizations
        foreach ($request->organization_ids as $index => $organizationId) {
            $isPrimary = ($index === 0); // First selected organization is primary

            Assignment::create([
                'employee_id' => $employee->id,
                'organization_id' => $organizationId,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'supervisor_id' => $request->supervisor_id,
                'start_date' => $request->hire_date,
                'is_primary' => $isPrimary,
                'status' => 'active',
            ]);

            // Record history for the primary assignment only to avoid clutter
            if ($isPrimary) {
                $employee->recordHistory(
                    'assignment_added',
                    null,
                    null,
                    ['organization_id' => $organizationId, 'position_id' => $request->position_id],
                    now(),
                    'Initial assignment upon hire'
                );
            }
        }

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
            'assignments.organization',
            'assignments.department',
            'assignments.position',
            'assignments.supervisor',
            'histories' => fn($q) => $q->latest()->take(10),
        ]);

        // Data for assignment modal
        $organizations = Organization::active()->get();
        $departments = Department::active()->get();
        $positions = Position::active()->get();
        $supervisors = Employee::active()->where('id', '!=', $employee->id)->get();

        return view('employees.show', compact('employee', 'organizations', 'departments', 'positions', 'supervisors'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $organizations = Organization::active()->get();
        $departments = Department::active()->get();
        $positions = Position::active()->get();
        $supervisors = Employee::active()
            ->where('id', '!=', $employee->id)
            ->get();

        return view('employees.edit', compact('employee', 'organizations', 'departments', 'positions', 'supervisors'));
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
            // Account Access
            'set_password' => 'nullable|boolean',
            'password' => 'nullable|required_if:set_password,1|string|min:8|confirmed',
        ]);

        // Track changes for history
        $changes = [];
        foreach ($validated as $key => $value) {
            if (in_array($key, ['set_password', 'password'])) continue;
            
            if ($employee->{$key} !== $value) {
                $changes[$key] = [
                    'old' => $employee->{$key},
                    'new' => $value,
                ];
            }
        }

        // Prepare update data
        $updateData = [
            ...$validated,
            'updated_by' => auth()->id(),
        ];

        // Set password if requested
        if ($request->boolean('set_password') && $request->filled('password')) {
            $updateData['password'] = $request->password; // Will be hashed by model cast
        }

        $employee->update($updateData);

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
