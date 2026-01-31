@extends('layouts.app')

@section('title', 'Departments')

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Departments</span>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Departments</h1>
            <p class="page-subtitle">Manage organizational departments</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('departments.create') }}" class="btn btn-primary">
                <i data-lucide="plus" width="18" height="18"></i>
                Add Department
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Parent</th>
                        <th>Employees</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                        <tr>
                            <td class="font-medium">{{ $department->code }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->branch->name }}</td>
                            <td>{{ $department->parent?->name ?? '-' }}</td>
                            <td>{{ $department->assignments_count }}</td>
                            <td>
                                <span class="badge badge-{{ $department->is_active ? 'success' : 'neutral' }}">
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('departments.edit', $department) }}" class="btn btn-ghost btn-sm">
                                        <i data-lucide="pencil" width="16" height="16"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: var(--space-8);">No departments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>lucide.createIcons();</script>
@endpush
