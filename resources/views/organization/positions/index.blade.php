@extends('layouts.app')

@section('title', 'Positions')

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Positions</span>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Positions</h1>
            <p class="page-subtitle">Manage job positions and titles</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('positions.create') }}" class="btn btn-primary">
                <i data-lucide="plus" width="18" height="18"></i>
                Add Position
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
                        <th>Level</th>
                        <th>Employees</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($positions as $position)
                        <tr>
                            <td class="font-medium">{{ $position->code }}</td>
                            <td>{{ $position->name }}</td>
                            <td><span class="badge badge-primary">{{ $position->level_label }}</span></td>
                            <td>{{ $position->assignments_count }}</td>
                            <td>
                                <span class="badge badge-{{ $position->is_active ? 'success' : 'neutral' }}">
                                    {{ $position->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('positions.edit', $position) }}" class="btn btn-ghost btn-sm">
                                        <i data-lucide="pencil" width="16" height="16"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding: var(--space-8);">No positions found</td>
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
