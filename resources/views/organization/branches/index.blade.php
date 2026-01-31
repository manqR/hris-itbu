@extends('layouts.app')

@section('title', 'Branches')

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Branches</span>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Branches</h1>
            <p class="page-subtitle">Manage organizational branches</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('branches.create') }}" class="btn btn-primary">
                <i data-lucide="plus" width="18" height="18"></i>
                Add Branch
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
                        <th>Type</th>
                        <th>Parent</th>
                        <th>Departments</th>
                        <th>Employees</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                        <tr>
                            <td class="font-medium">{{ $branch->code }}</td>
                            <td>{{ $branch->name }}</td>
                            <td><span class="badge badge-neutral">{{ ucfirst($branch->type) }}</span></td>
                            <td>{{ $branch->parent?->name ?? '-' }}</td>
                            <td>{{ $branch->departments_count }}</td>
                            <td>{{ $branch->assignments_count }}</td>
                            <td>
                                <span class="badge badge-{{ $branch->is_active ? 'success' : 'neutral' }}">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('branches.edit', $branch) }}" class="btn btn-ghost btn-sm">
                                        <i data-lucide="pencil" width="16" height="16"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted" style="padding: var(--space-8);">No branches found</td>
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
