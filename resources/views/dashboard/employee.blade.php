@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Welcome, {{ $employee->name }}</h1>
            <p class="page-subtitle">{{ $employee->primaryAssignment->position->name ?? 'Employee' }} at {{ $employee->primaryAssignment->branch->name ?? 'Unknown Branch' }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-muted">Employee ID</p>
            <p class="font-mono font-bold">{{ $employee->employee_number }}</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-8">
        {{-- Leave Balance Card --}}
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white border-0">
            <div class="card-body">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-blue-100 text-sm font-medium mb-1">Annual Leave Balance</div>
                        <div class="text-3xl font-bold">{{ $stats['leave_balance'] }} Days</div>
                    </div>
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i data-lucide="calendar" width="24" height="24" class="text-white"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-sm bg-white/20 hover:bg-white/30 text-white border-0 w-full">
                        Request Leave
                    </button>
                </div>
            </div>
        </div>

        {{-- Attendance Stats --}}
        <div class="card">
            <div class="card-body">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-muted text-sm font-medium mb-1">Attendance Rate</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['attendance_rate'] }}</div>
                    </div>
                    <div class="bg-green-100 p-2 rounded-lg text-green-600">
                        <i data-lucide="activity" width="24" height="24"></i>
                    </div>
                </div>
                <div class="text-xs text-muted mt-2">
                    Based on this month's schedule
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity / Attendance --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Recent Attendance</h3>
            <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-outline">View History</a>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAttendance as $record)
                        <tr>
                            <td class="font-medium">{{ $record->date->format('d M Y') }}</td>
                            <td>{{ $record->clock_in_time ? $record->clock_in_time->format('H:i') : '-' }}</td>
                            <td>{{ $record->clock_out_time ? $record->clock_out_time->format('H:i') : '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $record->status === 'present' ? 'success' : 'warning' }}">
                                    {{ ucfirst($record->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted p-4">No attendance records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
