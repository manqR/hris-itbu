@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header with Back Button --}}
    <div>
        <a href="{{ route('employees.show', $employee) }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm inline-flex items-center gap-2 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back to Employee Details</span>
        </a>
        <h1 class="text-2xl font-semibold text-white mb-1">Edit Employee</h1>
        <p class="text-slate-400 text-sm">Update personal and employment information</p>
    </div>
    
    <form method="POST" action="{{ route('employees.update', $employee) }}" class="space-y-5">
        @csrf
        @method('PUT')
        
        {{-- Personal Information --}}
        <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-blue-400"></i>
                    Personal Information
                </h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Employee Number <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="employee_number" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('employee_number') border-red-500/50 @enderror" 
                               value="{{ old('employee_number', $employee->employee_number) }}" required>
                        @error('employee_number')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('name') border-red-500/50 @enderror" 
                               value="{{ old('name', $employee->name) }}" required>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('email') border-red-500/50 @enderror" 
                               value="{{ old('email', $employee->email) }}" required>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Phone Number</label>
                        <input type="text" name="phone" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('phone', $employee->phone) }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Gender</label>
                        <select name="gender" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer">
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Birth Date</label>
                        <input type="date" name="birth_date" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('birth_date', $employee->birth_date?->format('Y-m-d')) }}">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Birth Place</label>
                        <input type="text" name="birth_place" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('birth_place', $employee->birth_place) }}">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Address</label>
                        <textarea name="address" rows="3" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all resize-none">{{ old('address', $employee->address) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Employment Information --}}
        <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-4 h-4 text-blue-400"></i>
                    Employment Details
                </h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Employment Type <span class="text-red-400">*</span>
                        </label>
                        <select name="employment_type" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer @error('employment_type') border-red-500/50 @enderror" required>
                            <option value="permanent" {{ old('employment_type', $employee->employment_type) == 'permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="contract" {{ old('employment_type', $employee->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="probation" {{ old('employment_type', $employee->employment_type) == 'probation' ? 'selected' : '' }}>Probation</option>
                            <option value="internship" {{ old('employment_type', $employee->employment_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        @error('employment_type')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">ID Number (KTP)</label>
                        <input type="text" name="id_number" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('id_number', $employee->id_number) }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tax Number (NPWP)</label>
                        <input type="text" name="tax_number" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('tax_number', $employee->tax_number) }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Bank Name</label>
                        <input type="text" name="bank_name" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('bank_name', $employee->bank_name) }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Bank Account Number</label>
                        <input type="text" name="bank_account" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('bank_account', $employee->bank_account) }}">
                    </div>

                    {{-- Assignment Information Note --}}
                    <div class="md:col-span-2 mt-4 p-4 bg-slate-800/50 border border-slate-700/50 rounded-lg flex gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5"></i>
                        <div class="text-sm text-slate-400">
                            To change the employee's Organization, Department, or Position, please use the 
                            <span class="text-white font-medium">Add Assignment</span> or 
                            <span class="text-white font-medium">Transfer</span> options from the employee detail page. 
                            This form only updates personal profile information.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Login Access --}}
        <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i data-lucide="lock" class="w-4 h-4 text-blue-400"></i>
                    Login Access
                </h3>
            </div>
            <div class="p-5">
                <div class="space-y-4">
                    @if($employee->hasLoginAccess())
                        <div class="flex items-center gap-2 mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
                            <i data-lucide="shield-check" class="w-5 h-5 text-emerald-400"></i>
                            <div>
                                <h4 class="text-sm font-medium text-emerald-400">Account Active</h4>
                                <p class="text-xs text-slate-400">Employee can log in with {{ $employee->email }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2 mb-4 p-3 bg-amber-500/10 border border-amber-500/20 rounded-lg">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-amber-400"></i>
                            <div>
                                <h4 class="text-sm font-medium text-amber-400">No Password Set</h4>
                                <p class="text-xs text-slate-400">This employee cannot log in.</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="set_password" name="set_password" value="1" 
                               class="w-4 h-4 rounded border-slate-600 bg-slate-700 text-blue-600 focus:ring-blue-500/50 focus:ring-offset-0 transition-all"
                               {{ old('set_password') ? 'checked' : '' }}
                               onchange="togglePasswordFields()">
                        <label for="set_password" class="text-sm text-slate-300 font-medium cursor-pointer">
                            {{ $employee->hasLoginAccess() ? 'Reset Password' : 'Set Password' }}
                        </label>
                    </div>

                    <div id="password-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ old('set_password') ? '' : 'hidden' }}">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                New Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" name="password" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('password') border-red-500/50 @enderror" 
                                   placeholder="Minimum 8 characters">
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                Confirm Password <span class="text-red-400">*</span>
                            </label>
                            <input type="password" name="password_confirmation" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                                   placeholder="Re-enter password">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function togglePasswordFields() {
                const checkbox = document.getElementById('set_password');
                const fields = document.getElementById('password-fields');
                if (checkbox && checkbox.checked) {
                    fields.classList.remove('hidden');
                } else {
                    fields.classList.add('hidden');
                }
            }
        </script>
        
        {{-- Form Actions --}}
        <div class="flex items-center justify-end gap-3 pb-6">
            <a href="{{ route('employees.show', $employee) }}" class="px-5 py-2.5 bg-slate-800/50 border border-slate-700/50 text-slate-300 hover:bg-slate-800 hover:text-white hover:border-slate-600 rounded-lg text-sm font-medium transition-all">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium transition-all shadow-sm inline-flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                Update Employee
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
