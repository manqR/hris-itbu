@extends('layouts.app')

@section('title', 'Add Employee')

@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('employees.index') }}" class="breadcrumb-item">Employees</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Add Employee</span>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Add Employee</h1>
            <p class="page-subtitle">Create a new employee record with initial assignment</p>
        </div>
    </div>
    
    <form method="POST" action="{{ route('employees.store') }}" class="grid grid-cols-2 gap-4">
        @csrf
        
        {{-- Basic Information --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label required">Employee Number</label>
                    <input type="text" name="employee_number" class="form-input @error('employee_number') error @enderror" 
                           value="{{ old('employee_number') }}" required>
                    @error('employee_number')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Full Name</label>
                    <input type="text" name="name" class="form-input @error('name') error @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Email</label>
                    <input type="email" name="email" class="form-input @error('email') error @enderror" 
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input @error('phone') error @enderror" 
                           value="{{ old('phone') }}">
                    @error('phone')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Birth Place</label>
                    <input type="text" name="birth_place" class="form-input" value="{{ old('birth_place') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-textarea" rows="3">{{ old('address') }}</textarea>
                </div>
            </div>
        </div>
        
        {{-- Employment Details --}}
        <div>
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Employment Details</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label required">Hire Date</label>
                        <input type="date" name="hire_date" class="form-input @error('hire_date') error @enderror" 
                               value="{{ old('hire_date', date('Y-m-d')) }}" required>
                        @error('hire_date')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Employment Type</label>
                        <select name="employment_type" class="form-select @error('employment_type') error @enderror" required>
                            <option value="permanent" {{ old('employment_type') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="probation" {{ old('employment_type') == 'probation' ? 'selected' : '' }}>Probation</option>
                            <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        @error('employment_type')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">ID Number (KTP)</label>
                            <input type="text" name="id_number" class="form-input" value="{{ old('id_number') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tax Number (NPWP)</label>
                            <input type="text" name="tax_number" class="form-input" value="{{ old('tax_number') }}">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-input" value="{{ old('bank_name') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bank Account</label>
                            <input type="text" name="bank_account" class="form-input" value="{{ old('bank_account') }}">
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Initial Assignment --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Initial Assignment</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label required">Branch</label>
                        <select name="branch_id" class="form-select @error('branch_id') error @enderror" required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->branch->name }} - {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Position</label>
                        <select name="position_id" class="form-select">
                            <option value="">Select Position</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="form-label">Supervisor</label>
                        <select name="supervisor_id" class="form-select">
                            <option value="">Select Supervisor</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Form Actions --}}
        <div class="col-span-2 flex justify-end gap-3 mt-4">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="check" width="18" height="18"></i>
                Create Employee
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
