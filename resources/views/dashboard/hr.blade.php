@extends('layouts.app')

@section('title', 'HR Dashboard')

@section('content')
    

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 mx-4 sm:mx-6 mt-8">
        <!-- Total Employees -->
        <div class="relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-blue-900/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
            <div class="relative bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl p-7 rounded-2xl border border-slate-700/50 hover:border-blue-500/50 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-start justify-between mb-5">
                    <div class="p-3 bg-gradient-to-br from-blue-600 to-blue-500 rounded-xl shadow-lg shadow-blue-900/50">
                        <i data-lucide="users" class="w-6 h-6 text-white"></i>
                    </div>
                    @if($stats['employees_growth'] > 0)
                        <div class="flex items-center gap-1 text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">
                            <i data-lucide="trending-up" class="w-3 h-3"></i>
                            <span>+{{ $stats['employees_growth'] }}%</span>
                        </div>
                    @endif
                </div>
                <div class="space-y-2">
                    <div class="text-sm font-medium text-slate-400">Total Employees</div>
                    <div class="text-4xl font-bold text-white tracking-tight">{{ $stats['employees'] }}</div>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-700/50">
                    <div class="text-xs text-slate-500">Active workforce</div>
                </div>
            </div>
        </div>

        <!-- Branches -->
        <div class="relative group ">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 to-indigo-900/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
            <div class="relative bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl p-7 rounded-2xl border border-slate-700/50 hover:border-indigo-500/50 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-start justify-between mb-5">
                    <div class="p-3 bg-gradient-to-br from-indigo-600 to-indigo-500 rounded-xl shadow-lg shadow-indigo-900/50">
                        <i data-lucide="building-2" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-400 bg-slate-800/50 px-2.5 py-1 rounded-full border border-slate-700/50">Operational</span>
                </div>
                <div class="space-y-2">
                    <div class="text-sm font-medium text-slate-400">Active Organizations</div>
                    <div class="text-4xl font-bold text-white tracking-tight">{{ $stats['organizations'] }}</div>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-700/50">
                    <div class="text-xs text-slate-500">Locations nationwide</div>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-600/20 to-violet-900/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
            <div class="relative bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl p-7 rounded-2xl border border-slate-700/50 hover:border-violet-500/50 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-start justify-between mb-5">
                    <div class="p-3 bg-gradient-to-br from-violet-600 to-violet-500 rounded-xl shadow-lg shadow-violet-900/50">
                        <i data-lucide="network" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-400 bg-slate-800/50 px-2.5 py-1 rounded-full border border-slate-700/50">Structure</span>
                </div>
                <div class="space-y-2">
                    <div class="text-sm font-medium text-slate-400">Departments</div>
                    <div class="text-4xl font-bold text-white tracking-tight">{{ $stats['departments'] }}</div>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-700/50">
                    <div class="text-xs text-slate-500">Organizational units</div>
                </div>
            </div>
        </div>

        <!-- Job Positions -->
        <div class="relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-600/20 to-amber-900/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
            <div class="relative bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl p-7 rounded-2xl border border-slate-700/50 hover:border-amber-500/50 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-start justify-between mb-5">
                    <div class="p-3 bg-gradient-to-br from-amber-600 to-amber-500 rounded-xl shadow-lg shadow-amber-900/50">
                        <i data-lucide="briefcase" class="w-6 h-6 text-white"></i>
                    </div>
                    <div class="flex items-center gap-1 text-xs font-medium text-amber-400 bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/20">
                        <span>Hiring</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="text-sm font-medium text-slate-400">Job Positions</div>
                    <div class="text-4xl font-bold text-white tracking-tight">{{ $stats['positions'] }}</div>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-700/50">
                    <div class="text-xs text-slate-500">Available roles</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mx-4 sm:mx-6 ">
        <!-- Organization Overview -->
        <div class="xl:col-span-2 bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl flex flex-col">
            <div class="px-7 py-6 border-b border-slate-700/50 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-white text-lg mb-1">Organization Structure</h3>
                    <p class="text-xs text-slate-400">Employee distribution across organizations</p>
                </div>
                <button class="text-slate-400 hover:text-blue-400 transition-colors p-2 hover:bg-slate-800/50 rounded-lg">
                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="p-7 grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach($organizations as $org)
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                        <div class="relative flex items-center justify-between p-6 bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 hover:border-blue-500/30 rounded-xl transition-all duration-300 cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600/20 to-blue-500/10 flex items-center justify-center border border-blue-500/20 shadow-lg group-hover:shadow-blue-500/20 transition-all">
                                    <i data-lucide="building" class="w-6 h-6 text-blue-400"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-white group-hover:text-blue-400 transition-colors">{{ $org->name }}</div>
                                    <div class="text-xs text-slate-500 font-mono mt-1">{{ $org->code }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-white group-hover:text-blue-400 transition-colors">{{ $org->employees_count ?? 0 }}</div>
                                <div class="text-xs text-slate-400 mt-1">employees</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Activity / New Joiners -->
        <div class="bg-gradient-to-br from-slate-900/90 to-slate-800/90 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-xl flex flex-col">
            <div class="px-7 py-6 border-b border-slate-700/50 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-white text-lg mb-1">New Joiners</h3>
                    <p class="text-xs text-slate-400">Last 7 days</p>
                </div>
                <a href="{{ route('employees.index') }}" class="text-xs font-medium text-blue-400 hover:text-blue-300 hover:underline transition-colors">View All</a>
            </div>
            <div class="flex-1 overflow-hidden">
                <div class="divide-y divide-slate-700/50">
                     @forelse($recentEmployees as $employee)
                        <div class="p-5 hover:bg-slate-800/50 transition-all duration-200 flex items-center gap-4 group cursor-pointer">
                            <div class="relative">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center text-sm font-bold text-white uppercase shadow-lg">
                                    {{ substr($employee->name, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-slate-900 rounded-full"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-white truncate group-hover:text-blue-400 transition-colors">{{ $employee->name }}</div>
                                <div class="text-xs text-slate-400 truncate flex items-center gap-1.5 mt-1">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    <span>{{ $employee->activeAssignments->first()->organization->name ?? 'Unassigned' }}</span>
                                </div>
                            </div>
                            <div class="text-xs font-medium text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">
                                New
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-800/50 flex items-center justify-center">
                                <i data-lucide="users" class="w-8 h-8 text-slate-600"></i>
                            </div>
                            <p class="text-sm text-slate-500">No new joiners this week</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="p-5 border-t border-slate-700/50 bg-slate-800/30">
                 <a href="{{ route('employees.index') }}" class="w-full py-3 flex items-center justify-center gap-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 rounded-xl border border-slate-700/50 hover:border-slate-600/50 transition-all">
                    <span>View All Employees</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
