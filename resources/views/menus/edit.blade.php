@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('menus.index') }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Edit Menu</h1>
            <p class="text-slate-400 mt-1">Update menu properties for "{{ $menu->name }}"</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg">
        <form action="{{ route('menus.update', $menu) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Menu Name --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Menu Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" required
                    class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all"
                    placeholder="e.g., Dashboard, Employees, Settings">
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Icon --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Icon <span class="text-slate-500">(Lucide icon name)</span>
                </label>
                <div class="flex items-center gap-3">
                    <input type="text" name="icon" value="{{ old('icon', $menu->icon) }}"
                        class="flex-1 px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all"
                        placeholder="e.g., users, settings, home">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/50 border border-slate-700/50 flex items-center justify-center">
                        <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-5 h-5 text-slate-400"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    <a href="https://lucide.dev/icons" target="_blank" class="text-blue-400 hover:underline">Browse Lucide icons →</a>
                </p>
            </div>

            {{-- Route --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Route Name
                </label>
                <input type="text" name="route" value="{{ old('route', $menu->route) }}"
                    class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all"
                    placeholder="e.g., employees.index, dashboard">
                <p class="text-xs text-slate-500 mt-1">Leave empty for parent menus that only group sub-menus</p>
            </div>

            {{-- Parent Menu --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Parent Menu
                </label>
                <select name="parent_id"
                    class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
                    <option value="">-- Top Level (No Parent) --</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Permission --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Required Permission
                </label>
                <select name="permission"
                    class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
                    <option value="">-- No Permission (Visible to All) --</option>
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->name }}" {{ old('permission', $menu->permission) == $permission->name ? 'selected' : '' }}>
                            {{ $permission->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">Users must have this permission to see this menu</p>
            </div>

            {{-- Order --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Display Order
                </label>
                <input type="number" name="order" value="{{ old('order', $menu->order) }}" min="0"
                    class="w-32 px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
                <p class="text-xs text-slate-500 mt-1">Lower numbers appear first</p>
            </div>

            {{-- Active Status --}}
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" 
                    {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                    class="w-5 h-5 rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-blue-500/50">
                <label for="is_active" class="text-sm text-slate-300">Menu is Active</label>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                <a href="{{ route('menus.index') }}" class="px-5 py-2.5 bg-slate-800/50 border border-slate-700/50 text-slate-300 hover:bg-slate-800 rounded-xl font-medium transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-medium transition-all">
                    Update Menu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
