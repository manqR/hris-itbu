<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    /**
     * Display a listing of menus
     */
    public function index()
    {
        $menus = Menu::with('children')
            ->topLevel()
            ->orderBy('order')
            ->get();

        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu
     */
    public function create()
    {
        $parentMenus = Menu::topLevel()->active()->orderBy('order')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('menus.create', compact('parentMenus', 'permissions'));
    }

    /**
     * Store a newly created menu
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:100',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'permission' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        Menu::create($validated);

        // Clear menu cache
        MenuService::clearAllCache();

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    /**
     * Show the form for editing a menu
     */
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::topLevel()
            ->where('id', '!=', $menu->id)
            ->active()
            ->orderBy('order')
            ->get();
        $permissions = Permission::orderBy('name')->get();

        return view('menus.edit', compact('menu', 'parentMenus', 'permissions'));
    }

    /**
     * Update the specified menu
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:100',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'permission' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Prevent menu from being its own parent
        if ($validated['parent_id'] == $menu->id) {
            return back()->withErrors(['parent_id' => 'Menu cannot be its own parent.']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $menu->update($validated);

        // Clear menu cache
        MenuService::clearAllCache();

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified menu
     */
    public function destroy(Menu $menu)
    {
        // Move children to top level or delete them
        Menu::where('parent_id', $menu->id)->update(['parent_id' => null]);

        $menu->delete();

        // Clear menu cache
        MenuService::clearAllCache();

        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully.');
    }

    /**
     * Reorder menus via AJAX
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:menus,id',
            'order.*.position' => 'required|integer|min:0',
        ]);

        foreach ($request->order as $item) {
            Menu::where('id', $item['id'])->update(['order' => $item['position']]);
        }

        MenuService::clearAllCache();

        return response()->json(['success' => true]);
    }

    /**
     * Toggle menu active status
     */
    public function toggle(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);
        
        MenuService::clearAllCache();

        return back()->with('success', 'Menu status updated.');
    }
}
