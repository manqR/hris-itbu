@extends('layouts.app')

@section('title', $employee->name)

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('employees.index') }}" class="breadcrumb-item">Employees</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">{{ $employee->name }}</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="flex items-center gap-4">
            <div class="user-avatar" style="width: 64px; height: 64px; font-size: var(--text-xl);">
                {{ strtoupper(substr($employee->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="page-title">{{ $employee->name }}</h1>
                <p class="page-subtitle">{{ $employee->employee_number }} · {{ $employee->email }}</p>
            </div>
        </div>
        <div class="page-actions">
            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-secondary">
                <i data-lucide="pencil" width="18" height="18"></i>
                Edit
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-4">
        {{-- Main Info --}}
        <div class="col-span-2">
            {{-- Personal Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Personal Information</h3>
                </div>
                <div class="card-body grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-muted mb-1">Gender</div>
                        <div class="font-medium">{{ ucfirst($employee->gender ?? '-') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted mb-1">Birth Date</div>
                        <div class="font-medium">{{ $employee->birth_date?->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted mb-1">Birth Place</div>
                        <div class="font-medium">{{ $employee->birth_place ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted mb-1">Phone</div>
                        <div class="font-medium">{{ $employee->phone ?? '-' }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="text-xs text-muted mb-1">Address</div>
                        <div class="font-medium">{{ $employee->address ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted mb-1">ID Number (KTP)</div>
                        <div class="font-medium">{{ $employee->id_number ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted mb-1">Tax Number (NPWP)</div>
                        <div class="font-medium">{{ $employee->tax_number ?? '-' }}</div>
                    </div>
                </div>
            </div>
            
            {{-- Assignments --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Assignments</h3>
                    <button type="button" class="btn btn-ghost btn-sm">
                        <i data-lucide="plus" width="16" height="16"></i>
                        Add Assignment
                    </button>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Supervisor</th>
                                <th>Period</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employee->assignments as $assignment)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @if($assignment->is_primary)
                                                <span class="badge badge-primary">Primary</span>
                                            @endif
                                            {{ $assignment->branch->name }}
                                        </div>
                                    </td>
                                    <td>{{ $assignment->department?->name ?? '-' }}</td>
                                    <td>{{ $assignment->position?->name ?? '-' }}</td>
                                    <td>{{ $assignment->supervisor?->name ?? '-' }}</td>
                                    <td>
                                        {{ $assignment->start_date->format('d M Y') }}
                                        @if($assignment->end_date)
                                            - {{ $assignment->end_date->format('d M Y') }}
                                        @else
                                            - Present
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assignment->status === 'active' ? 'success' : 'neutral' }}">
                                            {{ ucfirst($assignment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No assignments</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- History --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">History</h3>
                </div>
                <div class="card-body">
                    @forelse($employee->histories as $history)
                        <div class="flex gap-3 mb-4 pb-4" style="border-bottom: 1px solid var(--neutral-100);">
                            <div style="width: 8px; height: 8px; background: var(--primary-500); border-radius: 50%; margin-top: 6px;"></div>
                            <div class="flex-1">
                                <div class="font-medium">{{ $history->change_type_label }}</div>
                                <div class="text-sm text-muted">
                                    {{ $history->created_at->format('d M Y H:i') }}
                                    @if($history->notes)
                                        · {{ $history->notes }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted text-center">No history yet</div>
                    @endforelse
                </div>
            </div>
        </div>
        
        {{-- Sidebar Info --}}
        <div>
            {{-- Employment Status --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Employment</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="text-xs text-muted mb-1">Status</div>
                        <span class="badge badge-{{ $employee->employment_status === 'active' ? 'success' : 'neutral' }}">
                            {{ ucfirst($employee->employment_status) }}
                        </span>
                    </div>
                    <div class="mb-4">
                        <div class="text-xs text-muted mb-1">Type</div>
                        <div class="font-medium">{{ ucfirst($employee->employment_type) }}</div>
                    </div>
                    <div class="mb-4">
                        <div class="text-xs text-muted mb-1">Hire Date</div>
                        <div class="font-medium">{{ $employee->hire_date->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted mb-1">Years of Service</div>
                        <div class="font-medium">{{ $employee->years_of_service }} years</div>
                    </div>
                </div>
            </div>
            
            {{-- Bank Information --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bank Information</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="text-xs text-muted mb-1">Bank Name</div>
                        <div class="font-medium">{{ $employee->bank_name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-muted mb-1">Account Number</div>
                        <div class="font-medium">{{ $employee->bank_account ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
