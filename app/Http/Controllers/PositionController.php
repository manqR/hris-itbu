<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::withCount(['assignments' => fn($q) => $q->active()])
            ->orderBy('level', 'desc')
            ->get();

        return view('organization.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('organization.positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:positions',
            'name' => 'required|string|max:100',
            'level' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
        ]);

        Position::create([
            ...$validated,
            'is_active' => true,
        ]);

        return redirect()->route('positions.index')->with('success', 'Position created successfully.');
    }

    public function edit(Position $position)
    {
        return view('organization.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('positions')->ignore($position->id)],
            'name' => 'required|string|max:100',
            'level' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $position->update($validated);

        return redirect()->route('positions.index')->with('success', 'Position updated successfully.');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Position deleted successfully.');
    }
}
