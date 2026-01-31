@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Overview of your organization</p>
        </div>
    </div>
    
    {{-- Statistics Cards --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        {{-- Total Employees --}}
        <div class="card stat-card">
            <div class="flex items-center gap-3 mb-3">
                <div style="width: 40px; height: 40px; background: var(--primary-100); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="users" style="color: var(--primary-600);" width="20" height="20"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_employees'] ?? 0 }}</div>
            <div class="stat-label">Total Employees</div>
        </div>
        
        {{-- Active Branches --}}
        <div class="card stat-card">
            <div class="flex items-center gap-3 mb-3">
                <div style="width: 40px; height: 40px; background: var(--success-100); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="building-2" style="color: var(--success-600);" width="20" height="20"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_branches'] ?? 0 }}</div>
            <div class="stat-label">Active Branches</div>
        </div>
        
        {{-- Departments --}}
        <div class="card stat-card">
            <div class="flex items-center gap-3 mb-3">
                <div style="width: 40px; height: 40px; background: var(--warning-100); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="network" style="color: var(--warning-600);" width="20" height="20"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_departments'] ?? 0 }}</div>
            <div class="stat-label">Departments</div>
        </div>
        
        {{-- Positions --}}
        <div class="card stat-card">
            <div class="flex items-center gap-3 mb-3">
                <div style="width: 40px; height: 40px; background: var(--info-100); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="briefcase" style="color: var(--info-600);" width="20" height="20"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_positions'] ?? 0 }}</div>
            <div class="stat-label">Positions</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4">
        {{-- Recent Employees --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Employees</h3>
                <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
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
                            @forelse($recentEmployees ?? [] as $employee)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: var(--text-xs);">
                                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-medium">{{ $employee->name }}</div>
                                                <div class="text-xs text-muted">{{ $employee->employee_number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $employee->primaryAssignment?->branch?->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $employee->employment_status === 'active' ? 'success' : 'neutral' }}">
                                            {{ ucfirst($employee->employment_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No employees yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- Organization Overview --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Organization Overview</h3>
            </div>
            <div class="card-body">
                @forelse($branches ?? [] as $branch)
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div style="width: 40px; height: 40px; background: var(--neutral-100); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="building-2" style="color: var(--neutral-600);" width="18" height="18"></i>
                            </div>
                            <div>
                                <div class="font-medium">{{ $branch->name }}</div>
                                <div class="text-xs text-muted">{{ $branch->code }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold">{{ $branch->assignments_count ?? 0 }}</div>
                            <div class="text-xs text-muted">employees</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted">No branches configured</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
