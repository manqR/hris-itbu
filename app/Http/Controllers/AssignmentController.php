<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Assignment;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Store a new assignment for an employee.
     */
    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'supervisor_id' => 'nullable|exists:employees,id',
            'start_date' => 'required|date',
            'is_primary' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check for duplicate active assignment in the same organization
        $existingAssignment = $employee->activeAssignments()
            ->where('organization_id', $validated['organization_id'])
            ->first();

        if ($existingAssignment) {
            return back()->withErrors([
                'organization_id' => 'Employee already has an active assignment in this organization.'
            ])->withInput();
        }

        // If setting as primary, unset other primary assignments
        if ($request->boolean('is_primary')) {
            $employee->activeAssignments()->update(['is_primary' => false]);
        }

        $assignment = Assignment::create([
            'employee_id' => $employee->id,
            'organization_id' => $validated['organization_id'],
            'department_id' => $validated['department_id'] ?? null,
            'position_id' => $validated['position_id'] ?? null,
            'supervisor_id' => $validated['supervisor_id'] ?? null,
            'start_date' => $validated['start_date'],
            'is_primary' => $request->boolean('is_primary'),
            'status' => 'active',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Record history
        $employee->recordHistory(
            'assignment_added',
            null,
            null,
            [
                'organization_id' => $validated['organization_id'],
                'position_id' => $validated['position_id'] ?? null,
            ],
            now(),
            $validated['notes'] ?? 'New assignment added'
        );

        return back()->with('success', 'Assignment added successfully.');
    }

    /**
     * Update an existing assignment.
     */
    public function update(Request $request, Employee $employee, Assignment $assignment)
    {
        // Ensure assignment belongs to employee
        if ($assignment->employee_id !== $employee->id) {
            abort(403);
        }

        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'supervisor_id' => 'nullable|exists:employees,id',
            'is_primary' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        // Track changes
        $oldValues = [
            'position_id' => $assignment->position_id,
            'department_id' => $assignment->department_id,
            'supervisor_id' => $assignment->supervisor_id,
        ];

        // If setting as primary, unset other primary assignments
        if ($request->boolean('is_primary') && !$assignment->is_primary) {
            $employee->activeAssignments()
                ->where('id', '!=', $assignment->id)
                ->update(['is_primary' => false]);
        }

        $assignment->update([
            'department_id' => $validated['department_id'] ?? null,
            'position_id' => $validated['position_id'] ?? null,
            'supervisor_id' => $validated['supervisor_id'] ?? null,
            'is_primary' => $request->boolean('is_primary'),
            'notes' => $validated['notes'] ?? null,
        ]);

        // Record history if significant changes
        if ($oldValues['position_id'] !== $assignment->position_id) {
            $employee->recordHistory(
                'position_change',
                'position_id',
                $oldValues['position_id'],
                $assignment->position_id,
                now()
            );
        }

        return back()->with('success', 'Assignment updated successfully.');
    }

    /**
     * End an assignment.
     */
    public function destroy(Request $request, Employee $employee, Assignment $assignment)
    {
        // Ensure assignment belongs to employee
        if ($assignment->employee_id !== $employee->id) {
            abort(403);
        }

        $validated = $request->validate([
            'end_date' => 'required|date',
            'reason' => 'nullable|string|max:500',
        ]);

        $assignment->update([
            'end_date' => $validated['end_date'],
            'status' => 'ended',
            'notes' => $validated['reason'] ?? $assignment->notes,
        ]);

        // Record history
        $employee->recordHistory(
            'assignment_ended',
            null,
            ['status' => 'active'],
            ['status' => 'ended'],
            now(),
            $validated['reason'] ?? 'Assignment ended'
        );

        return back()->with('success', 'Assignment ended successfully.');
    }
}
