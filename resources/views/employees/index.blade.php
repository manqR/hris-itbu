@extends('layouts.app')

@section('title', 'Employees')

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Employees</span>
@endsection

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Employees</h1>
            <p class="page-subtitle">Manage all employees across branches</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                <i data-lucide="plus" width="18" height="18"></i>
                Add Employee
            </a>
        </div>
    </div>
    
    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('employees.index') }}" class="flex gap-4 items-end">
                <div class="form-group mb-0" style="flex: 1;">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-input" placeholder="Name, ID, or email..." value="{{ request('search') }}">
                </div>
                <div class="form-group mb-0" style="width: 200px;">
                    <label class="form-label">Branch</label>
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0" style="width: 150px;">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                        <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i data-lucide="search" width="16" height="16"></i>
                    Filter
                </button>
                @if(request()->hasAny(['search', 'branch_id', 'status']))
                    <a href="{{ route('employees.index') }}" class="btn btn-ghost">Clear</a>
                @endif
            </form>
        </div>
    </div>
    
    {{-- Employee Table --}}
    <div class="card">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Employee</th>
                        <th>Branch</th>
                        <th>Position</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td class="font-medium">{{ $employee->employee_number }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="user-avatar" style="width: 36px; height: 36px; font-size: var(--text-sm);">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $employee->name }}</div>
                                        <div class="text-xs text-muted">{{ $employee->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->primaryAssignment?->branch?->name ?? '-' }}</td>
                            <td>{{ $employee->primaryAssignment?->position?->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-neutral">{{ ucfirst($employee->employment_type) }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $employee->employment_status === 'active' ? 'success' : 'neutral' }}">
                                    <span class="status-dot {{ $employee->employment_status }}"></span>
                                    {{ ucfirst($employee->employment_status) }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('employees.show', $employee) }}" class="btn btn-ghost btn-sm" title="View">
                                        <i data-lucide="eye" width="16" height="16"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-ghost btn-sm" title="Edit">
                                        <i data-lucide="pencil" width="16" height="16"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: var(--space-8);">
                                <div style="color: var(--neutral-400); margin-bottom: var(--space-4);">
                                    <i data-lucide="users" width="48" height="48"></i>
                                </div>
                                <div class="text-muted">No employees found</div>
                                <a href="{{ route('employees.create') }}" class="btn btn-primary mt-4">Add your first employee</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($employees->hasPages())
            <div class="card-footer">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
