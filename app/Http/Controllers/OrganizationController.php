<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::withCount(['departments', 'assignments' => fn($q) => $q->active()])
            ->latest()
            ->get();

        return view('organization.organizations.index', compact('organizations'));
    }

    public function create()
    {
        // For potential future hierarchy
        $parentOrganizations = Organization::active()->get();
        return view('organization.organizations.create', compact('parentOrganizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:organizations',
            'name' => 'required|string|max:100',
            'type' => 'required|in:yayasan,unit,cabang',
            'parent_id' => 'nullable|exists:organizations,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        Organization::create([
            ...$validated,
            'is_active' => true,
        ]);

        return redirect()->route('organizations.index')->with('success', 'Organization created successfully.');
    }

    public function edit(Organization $organization)
    {
        $parentOrganizations = Organization::active()->where('id', '!=', $organization->id)->get();
        return view('organization.organizations.edit', compact('organization', 'parentOrganizations'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('organizations')->ignore($organization->id)],
            'name' => 'required|string|max:100',
            'type' => 'required|in:yayasan,unit,cabang',
            'parent_id' => 'nullable|exists:organizations,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $organization->update($validated);

        return redirect()->route('organizations.index')->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organization deleted successfully.');
    }
}
