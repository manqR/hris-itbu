@extends('layouts.app')

@section('title', 'HR Dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">HR Dashboard</h1>
            <p class="page-subtitle">Overview of organization and personnel</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('attendance.upload') }}" class="btn btn-primary">
                <i data-lucide="upload" width="18" height="18"></i>
                Upload Attendance
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid mb-8">
        <div class="stat-card">
            <div class="stat-icon bg-blue-100 text-blue-600">
                <i data-lucide="users" width="24" height="24"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['employees'] }}</div>
                <div class="stat-label">Active Employees</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green-100 text-green-600">
                <i data-lucide="building-2" width="24" height="24"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['branches'] }}</div>
                <div class="stat-label">Branches</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-purple-100 text-purple-600">
                <i data-lucide="network" width="24" height="24"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['departments'] }}</div>
                <div class="stat-label">Departments</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-orange-100 text-orange-600">
                <i data-lucide="briefcase" width="24" height="24"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['positions'] }}</div>
                <div class="stat-label">Positions</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        {{-- Recent Employees --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Employees</h3>
                <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline">View All</a>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Branch</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEmployees as $employee)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                <span>{{ substr($employee->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $employee->name }}</div>
                                            <div class="text-xs text-muted">{{ $employee->employee_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($employee->activeAssignments->isNotEmpty())
                                        {{ $employee->activeAssignments->first()->branch->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-success">Active</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted p-4">No employees yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Organization Overview --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Organization Overview</h3>
            </div>
            <div class="p-4 space-y-4">
                @foreach($branches as $branch)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-white flex items-center justify-center border shadow-sm">
                                <i data-lucide="building" class="text-gray-500" width="20" height="20"></i>
                            </div>
                            <div>
                                <div class="font-medium">{{ $branch->name }}</div>
                                <div class="text-xs text-muted">{{ $branch->code }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold">{{ $branches->find($branch->id)->employees_count ?? 0 }}</div>
                            <div class="text-xs text-muted">employees</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
