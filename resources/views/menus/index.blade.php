@extends('layouts.app')

@section('title', 'Menu Management')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Menu Management</h1>
            <p class="text-slate-400 mt-1">Manage sidebar menu items and their visibility</p>
        </div>
        <a href="{{ route('menus.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-medium transition-all">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add New Menu
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Menu List --}}
    <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-400 uppercase bg-slate-800/50 border-b border-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 w-12">Order</th>
                        <th class="px-6 py-4">Menu</th>
                        <th class="px-6 py-4">Route</th>
                        <th class="px-6 py-4">Permission</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($menus as $menu)
                        {{-- Parent Menu --}}
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-slate-400">{{ $menu->order }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                        <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-4 h-4 text-blue-400"></i>
                                    </div>
                                    <span class="font-medium text-white">{{ $menu->name }}</span>
                                    @if($menu->children->count() > 0)
                                        <span class="text-xs bg-slate-700/50 text-slate-400 px-2 py-0.5 rounded">
                                            {{ $menu->children->count() }} sub-menus
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-400 font-mono text-xs">
                                {{ $menu->route ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($menu->permission)
                                    <span class="text-xs bg-purple-500/10 text-purple-400 px-2 py-1 rounded">
                                        {{ $menu->permission }}
                                    </span>
                                @else
                                    <span class="text-slate-500">All users</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('menus.toggle', $menu) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium {{ $menu->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                        <i data-lucide="{{ $menu->is_active ? 'check-circle' : 'x-circle' }}" class="w-3 h-3"></i>
                                        {{ $menu->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('menus.edit', $menu) }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-colors">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this menu?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Child Menus --}}
                        @foreach($menu->children as $child)
                            <tr class="hover:bg-slate-800/30 transition-colors bg-slate-800/10">
                                <td class="px-6 py-3 text-slate-500 text-xs">{{ $menu->order }}.{{ $child->order }}</td>
                                <td class="px-6 py-3 pl-12">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-slate-600"></div>
                                        <div class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center">
                                            <i data-lucide="{{ $child->icon ?? 'circle' }}" class="w-3.5 h-3.5 text-slate-400"></i>
                                        </div>
                                        <span class="text-slate-300">{{ $child->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-slate-500 font-mono text-xs">
                                    {{ $child->route ?? '-' }}
                                </td>
                                <td class="px-6 py-3">
                                    @if($child->permission)
                                        <span class="text-xs bg-purple-500/10 text-purple-400 px-2 py-1 rounded">
                                            {{ $child->permission }}
                                        </span>
                                    @else
                                        <span class="text-slate-500">All users</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <form action="{{ route('menus.toggle', $child) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium {{ $child->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                            <i data-lucide="{{ $child->is_active ? 'check-circle' : 'x-circle' }}" class="w-3 h-3"></i>
                                            {{ $child->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('menus.edit', $child) }}" class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-colors">
                                            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                                        </a>
                                        <form action="{{ route('menus.destroy', $child) }}" method="POST" class="inline" onsubmit="return confirm('Delete this sub-menu?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i data-lucide="menu" class="w-10 h-10 text-slate-600 mx-auto mb-3"></i>
                                <p class="text-slate-400">No menus found</p>
                                <a href="{{ route('menus.create') }}" class="text-blue-400 hover:text-blue-300 text-sm mt-2 inline-block">
                                    Create your first menu
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
