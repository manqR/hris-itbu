@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="space-y-5">
    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
            <h1 class="text-2xl font-semibold text-white mb-1">Employee Management</h1>
            <p class="text-sm text-slate-400">View and manage all employees across your organization</p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('employees.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition-all shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Add Employee</span>
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg">
        <div class="p-4">
            <form method="GET" action="{{ route('employees.index') }}">
                <div class="flex flex-col lg:flex-row gap-3">
                    {{-- Search --}}
                    <div class="flex-1 lg:max-w-md">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search by name, email, or ID..." 
                                class="w-full h-10 pl-10 pr-4 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all"
                            >
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="flex flex-col sm:flex-row gap-3 lg:flex-1">
                        <div class="flex-1 sm:max-w-[200px]">
                            {{-- Organization Filter --}}
                            <div class="relative">
                                <i data-lucide="building-2" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                                <select 
                                    name="organization_id" 
                                    onchange="this.form.submit()"
                                    class="w-full h-10 pl-9 pr-4 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer appearance-none"
                                >
                                    <option value="">All Organizations</option>
                                    @foreach($organizations as $org)
                                        <option value="{{ $org->id }}" {{ request('organization_id') == $org->id ? 'selected' : '' }}>
                                            {{ $org->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex-1 sm:max-w-[160px]">
                            <select 
                                name="status" 
                                class="w-full h-10 px-3.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer"
                            >
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                                <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            <button 
                                type="submit" 
                                class="h-10 px-4 bg-slate-700/50 hover:bg-slate-700 border border-slate-600/50 text-white text-sm font-medium rounded-lg transition-all"
                            >
                                Apply
                            </button>
                            
                            @if(request()->hasAny(['search', 'organization_id', 'status']))
                                <a 
                                    href="{{ route('employees.index') }}" 
                                    class="h-10 px-3.5 flex items-center justify-center bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 text-slate-400 hover:text-white rounded-lg transition-all"
                                    title="Clear all filters"
                                >
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Secondary Actions --}}
                    <div class="flex gap-2 lg:flex-shrink-0">
                        <button 
                            type="button"
                            class="h-10 px-3.5 flex items-center gap-2 bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 text-slate-400 hover:text-white text-sm rounded-lg transition-all"
                            title="Import employees"
                        >
                            <i data-lucide="upload" class="w-4 h-4"></i>
                            <span class="hidden xl:inline">Import</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-700/50 bg-slate-800/30">
                        <th class="px-4 py-3.5 text-left">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">ID</span>
                        </th>
                        <th class="px-4 py-3.5 text-left">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Employee</span>
                        </th>
                        <th class="px-4 py-3.5 text-left">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Organization</span>
                        </th>
                        <th class="px-4 py-3.5 text-left">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Position</span>
                        </th>
                        <th class="px-4 py-3.5 text-left">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Type</span>
                        </th>
                        <th class="px-4 py-3.5 text-left">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Status</span>
                        </th>
                        <th class="px-4 py-3.5 text-right">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-slate-800/30 transition-colors group">
                            <td class="px-4 py-3.5">
                                <span class="text-xs font-mono text-slate-500">{{ $employee->employee_number }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center text-sm font-semibold text-white flex-shrink-0">
                                        {{ substr($employee->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('employees.show', $employee) }}" class="text-sm font-medium text-white hover:text-blue-400 transition-colors truncate">{{ $employee->name }}</a>
                                        <div class="text-xs text-slate-400 truncate">{{ $employee->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="text-sm text-slate-300 flex items-center gap-1.5">
                                    <i data-lucide="building-2" class="w-3.5 h-3.5 text-slate-500"></i>
                                    {{ $employee->primaryAssignment->organization->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="text-sm text-slate-300">{{ $employee->primaryAssignment?->position?->name ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-800/60 text-slate-300 border border-slate-700/40">
                                    {{ ucfirst($employee->employment_type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if($employee->employment_status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-800/60 text-slate-400 border border-slate-700/40">
                                        {{ ucfirst($employee->employment_status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <a 
                                        href="{{ route('employees.show', $employee) }}" 
                                        class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-800/50 rounded-md transition-colors"
                                        title="View details"
                                    >
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a 
                                        href="{{ route('employees.edit', $employee) }}" 
                                        class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-800/50 rounded-md transition-colors"
                                        title="Edit employee"
                                    >
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-16">
                                <div class="flex flex-col items-center justify-center text-center max-w-sm mx-auto">
                                    <div class="w-14 h-14 rounded-xl bg-slate-800/50 flex items-center justify-center mb-4">
                                        <i data-lucide="users" class="w-7 h-7 text-slate-600"></i>
                                    </div>
                                    <h3 class="text-base font-semibold text-white mb-1">No employees found</h3>
                                    <p class="text-sm text-slate-400 mb-5">
                                        @if(request()->hasAny(['search', 'organization_id', 'status']))
                                            No results match your current filters. Try adjusting your search criteria.
                                        @else
                                            Get started by adding your first employee to the system.
                                        @endif
                                    </p>
                                    @if(request()->hasAny(['search', 'organization_id', 'status']))
                                        <a 
                                            href="{{ route('employees.index') }}" 
                                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors"
                                        >
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                            Clear filters
                                        </a>
                                    @else
                                        <a 
                                            href="{{ route('employees.create') }}" 
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition-all"
                                        >
                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                            Add Employee
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($employees->hasPages())
            <div class="px-4 py-3 border-t border-slate-700/50 bg-slate-800/20">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
