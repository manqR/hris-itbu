<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['organization', 'parent'])
            ->withCount(['assignments' => fn($q) => $q->active()])
            ->latest()
            ->get();

        return view('organization.departments.index', compact('departments'));
    }

    public function create()
    {
        $organizations = Organization::active()->get();
        $parentDepartments = Department::active()->get();
        return view('organization.departments.create', compact('organizations', 'parentDepartments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:departments,id',
            'description' => 'nullable|string',
        ]);

        Department::create([
            ...$validated,
            'is_active' => true,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $organizations = Organization::active()->get();
        $parentDepartments = Department::active()->where('id', '!=', $department->id)->get();
        return view('organization.departments.edit', compact('department', 'organizations', 'parentDepartments'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'code' => ['required', 'string', 'max:20'],
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:departments,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
