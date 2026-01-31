<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('parent')
            ->withCount(['departments', 'assignments' => fn($q) => $q->active()])
            ->latest()
            ->get();

        return view('organization.branches.index', compact('branches'));
    }

    public function create()
    {
        $parentBranches = Branch::active()->get();
        return view('organization.branches.create', compact('parentBranches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:branches',
            'name' => 'required|string|max:100',
            'type' => 'required|in:yayasan,unit,cabang',
            'parent_id' => 'nullable|exists:branches,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        Branch::create([
            ...$validated,
            'is_active' => true,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        $parentBranches = Branch::active()->where('id', '!=', $branch->id)->get();
        return view('organization.branches.edit', compact('branch', 'parentBranches'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('branches')->ignore($branch->id)],
            'name' => 'required|string|max:100',
            'type' => 'required|in:yayasan,unit,cabang',
            'parent_id' => 'nullable|exists:branches,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $branch->update([...$validated, 'updated_by' => auth()->id()]);

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }
}
