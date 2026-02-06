@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Welcome Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">
                Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ explode(' ', $employee->name)[0] }}!
            </h1>
            <p class="text-slate-400 mt-1">Here's a summary of your activity and schedule for today.</p>
        </div>
        <div class="text-sm text-slate-400">
            <span class="font-mono bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-700/50">
                {{ now()->format('l, d F Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Clock In/Out & ID Card --}}
        <div class="space-y-6">
            {{-- Clock In/Out Widget --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-blue-400"></i>
                        Today's Time
                    </h3>
                </div>
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="text-4xl font-bold text-white font-mono" id="currentTime">
                            {{ now()->format('H:i:s') }}
                        </div>
                        <div class="text-sm text-slate-400 mt-1">Current Time</div>
                    </div>                 
                </div>
            </div>

            {{-- Employee ID Card --}}
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-blue-500 rounded-full blur-2xl opacity-30"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-xl font-bold">
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-lg leading-tight">{{ $employee->name }}</div>
                            <div class="text-blue-200 text-sm mt-0.5">{{ $employee->primaryAssignment->position->name ?? 'Employee' }}</div>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-white/20 flex justify-between items-end">
                        <div>
                            <div class="text-xs text-blue-200 uppercase tracking-wider font-medium">Employee ID</div>
                            <div class="text-lg font-mono font-semibold mt-1">{{ $employee->employee_number }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-blue-200 uppercase tracking-wider font-medium flex items-center gap-1 justify-end">
                                <i data-lucide="building-2" class="w-3 h-3"></i> Organization
                            </div>
                            <div class="text-sm font-medium mt-1">{{ $employee->primaryAssignment->organization->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Middle Column: Stats & Quick Actions --}}
        <div class="space-y-6">
            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 gap-4">
                {{-- Leave Balance --}}
                <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                            <i data-lucide="calendar-days" class="w-5 h-5 text-purple-400"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white">{{ $stats['leave_balance'] }}</div>
                    <div class="text-xs text-slate-400 mt-1">Leave Days Left</div>
                </div>

                {{-- Attendance Rate --}}
                <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                            <i data-lucide="trending-up" class="w-5 h-5 text-emerald-400"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white">{{ $stats['attendance_rate'] }}</div>
                    <div class="text-xs text-slate-400 mt-1">Attendance Rate</div>
                </div>

                {{-- Days Worked --}}
                <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                            <i data-lucide="briefcase" class="w-5 h-5 text-blue-400"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white">{{ $stats['days_worked'] }}</div>
                    <div class="text-xs text-slate-400 mt-1">Days This Month</div>
                </div>

                {{-- Late Count --}}
                <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-400"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-white">{{ $stats['late_count'] }}</div>
                    <div class="text-xs text-slate-400 mt-1">Late This Month</div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4 text-yellow-400"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-4 grid grid-cols-2 gap-3">
                    <a href="#" class="flex flex-col items-center gap-2 p-4 bg-slate-800/50 hover:bg-slate-800 rounded-lg border border-slate-700/50 transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500/20 transition-colors">
                            <i data-lucide="calendar-plus" class="w-5 h-5 text-blue-400"></i>
                        </div>
                        <span class="text-xs text-slate-300 font-medium">Request Leave</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="flex flex-col items-center gap-2 p-4 bg-slate-800/50 hover:bg-slate-800 rounded-lg border border-slate-700/50 transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition-colors">
                            <i data-lucide="history" class="w-5 h-5 text-emerald-400"></i>
                        </div>
                        <span class="text-xs text-slate-300 font-medium">Attendance Log</span>
                    </a>
                    <a href="{{ route('employees.show', $employee) }}" class="flex flex-col items-center gap-2 p-4 bg-slate-800/50 hover:bg-slate-800 rounded-lg border border-slate-700/50 transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 transition-colors">
                            <i data-lucide="user" class="w-5 h-5 text-purple-400"></i>
                        </div>
                        <span class="text-xs text-slate-300 font-medium">My Profile</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-2 p-4 bg-slate-800/50 hover:bg-slate-800 rounded-lg border border-slate-700/50 transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center group-hover:bg-amber-500/20 transition-colors">
                            <i data-lucide="file-text" class="w-5 h-5 text-amber-400"></i>
                        </div>
                        <span class="text-xs text-slate-300 font-medium">Payslip</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Right Column: Recent News --}}
        <div class="space-y-6">
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="newspaper" class="w-4 h-4 text-blue-400"></i>
                        Recent News
                    </h3>
                    <a href="#" class="text-xs text-blue-400 hover:text-blue-300 font-medium transition-colors">
                        View All
                    </a>
                </div>
                <div class="divide-y divide-slate-700/50 max-h-[400px] overflow-y-auto custom-scrollbar">
                    @forelse($recentNews as $news)
                        <div class="px-6 py-4 hover:bg-slate-800/20 transition-colors cursor-pointer group">
                            <div class="flex items-start gap-3">
                                {{-- Type Icon --}}
                                <div class="w-8 h-8 rounded-lg bg-{{ $news->type_color }}-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="{{ $news->type_icon }}" class="w-4 h-4 text-{{ $news->type_color }}-400"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if($news->is_pinned)
                                            <i data-lucide="pin" class="w-3 h-3 text-amber-400"></i>
                                        @endif
                                        <span class="text-sm font-medium text-white group-hover:text-blue-400 transition-colors line-clamp-1">
                                            {{ $news->title }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 line-clamp-2 mb-2">
                                        {{ $news->excerpt ?? \Illuminate\Support\Str::limit($news->content, 80) }}
                                    </p>
                                    <div class="flex items-center gap-3 text-[10px] text-slate-500">
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-{{ $news->type_color }}-500/10 text-{{ $news->type_color }}-400 capitalize">
                                            {{ $news->type }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            {{ $news->published_at?->diffForHumans() ?? 'Just now' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <i data-lucide="newspaper" class="w-8 h-8 text-slate-600 mx-auto mb-2"></i>
                            <p class="text-sm text-slate-500">No news available</p>
                            <p class="text-xs text-slate-600 mt-1">Check back later for updates</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Employment Info --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-blue-400"></i>
                        Employment Info
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400">Department</span>
                        <span class="text-sm text-white font-medium">{{ $employee->primaryAssignment->department->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400">Hire Date</span>
                        <span class="text-sm text-white font-medium">{{ $employee->hire_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400">Tenure</span>
                        <span class="text-sm text-white font-medium">{{ $employee->years_of_service }} Years</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400">Employment Type</span>
                        <span class="text-sm text-white font-medium">{{ ucfirst($employee->employment_type) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Live clock update
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const clockElement = document.getElementById('currentTime');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    }
    setInterval(updateClock, 1000);
</script>
@endpush
@endsection
