@extends('layouts.app')

@section('title', 'Attendance')

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Attendance</span>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Attendance</h1>
            <p class="page-subtitle">Track your daily attendance</p>
        </div>
        
        {{-- Assignment Selector (if multiple) --}}
        @if($assignments->count() > 1)
            <div class="page-actions">
                <form method="GET" action="{{ route('attendance.index') }}">
                    <select name="assignment_id" class="form-select" onchange="this.form.submit()">
                        @foreach($assignments as $assignment)
                            <option value="{{ $assignment->id }}" {{ $selectedAssignmentId == $assignment->id ? 'selected' : '' }}>
                                {{ $assignment->position->name }} at {{ $assignment->branch->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif
    </div>
    
    <div class="grid grid-cols-3 gap-6">
        @can('clock_in_self_service')
            {{-- Clock In/Out Widget (Only if permitted) --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daily Attendance</h3>
                </div>
                {{-- ... widget content ... --}}
            </div>
        @else
            {{-- Read Only Summary for Upload-based Attendance --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance Status</h3>
                </div>
                <div class="card-body p-6">
                    <div class="text-muted mb-4">
                        Attendance data is uploaded periodically by HR.
                    </div>
                    
                    @if($todayAttendance)
                        <div class="alert alert-success">
                            <div class="font-bold">Present</div>
                            <div class="text-sm">Recorded for today</div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <div class="text-sm">No record for today yet.</div>
                        </div>
                    @endif
                </div>
            </div>
        @endcan
        
        {{-- Monthly History --}}
        <div class="col-span-2 card">
            <div class="card-header">
                <h3 class="card-title">This Month's History</h3>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Work Hours</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $record)
                            <tr>
                                <td class="font-medium">{{ $record->date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $record->status === 'present' ? 'success' : 'warning' }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                                <td>{{ $record->clock_in_time ? $record->clock_in_time->format('H:i') : '-' }}</td>
                                <td>{{ $record->clock_out_time ? $record->clock_out_time->format('H:i') : '-' }}</td>
                                <td>
                                    @if($record->clock_in_time && $record->clock_out_time)
                                        {{ $record->clock_in_time->diff($record->clock_out_time)->format('%H:%I') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-muted truncate" style="max-width: 200px;">
                                    {{ $record->notes ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted p-6">No attendance records for this month</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
    
    // Optional: Add Geolocation logic here
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.name = 'latitude';
                latInput.value = position.coords.latitude;
                
                const longInput = document.createElement('input');
                longInput.type = 'hidden';
                longInput.name = 'longitude';
                longInput.value = position.coords.longitude;
                
                form.appendChild(latInput);
                form.appendChild(longInput);
            });
        });
    }
</script>
@endpush
