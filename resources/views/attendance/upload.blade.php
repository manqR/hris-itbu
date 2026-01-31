@extends('layouts.app')

@section('title', 'Upload Attendance')

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('hr.dashboard') }}" class="breadcrumb-item">HR Dashboard</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Upload Attendance</span>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Upload Attendance</h1>
            <p class="page-subtitle">Import attendance logs from fingerprint machine or Excel</p>
        </div>
        <div class="page-actions">
           <a href="{{ route('hr.dashboard') }}" class="btn btn-outline">Back to Dashboard</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">CSV Import</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(session('import_errors'))
                    <div class="alert alert-warning mb-4">
                        <strong>Warning: Some records were skipped:</strong>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach(session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('attendance.upload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-6">
                        <label class="form-label">Select CSV File</label>
                        <input type="file" name="file" class="file-input w-full" accept=".csv, .txt">
                        <div class="text-xs text-muted mt-2">
                            Max file size: 2MB. Format: CSV.
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">
                        <i data-lucide="upload-cloud" width="20" height="20"></i>
                        Process Import
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Format Guide</h3>
            </div>
            <div class="card-body">
                <p class="text-sm text-gray-600 mb-4">
                    Please ensure your CSV file follows this exact format (headers are optional but recommended):
                </p>
                
                <div class="bg-gray-100 p-4 rounded-lg font-mono text-xs mb-4">
                    EmployeeNumber, Date, ClockIn, ClockOut<br>
                    EMP001, 2026-02-01, 08:00, 17:00<br>
                    EMP002, 2026-02-01, 08:15, 17:15
                </div>
                
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <i data-lucide="check-circle" class="text-green-500 w-4 h-4 mt-0.5"></i>
                        Date format must be YYYY-MM-DD
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="check-circle" class="text-green-500 w-4 h-4 mt-0.5"></i>
                        Time format must be HH:MM (24-hour)
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="check-circle" class="text-green-500 w-4 h-4 mt-0.5"></i>
                        Employee Number must match existing records
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
