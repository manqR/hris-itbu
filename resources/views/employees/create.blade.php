@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header with Back Button --}}
    <div>
        <a href="{{ route('employees.index') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm inline-flex items-center gap-2 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back to Employees</span>
        </a>
        <h1 class="text-2xl font-semibold text-white mb-1">Add New Employee</h1>
        <p class="text-slate-400 text-sm">Fill in the employee information below</p>
    </div>
    
    <form method="POST" action="{{ route('employees.store') }}" class="space-y-5">
        @csrf
        
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
                               value="{{ old('employee_number') }}" placeholder="e.g., EMP001" required>
                        @error('employee_number')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('name') border-red-500/50 @enderror" 
                               value="{{ old('name') }}" placeholder="Enter full name" required>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('email') border-red-500/50 @enderror" 
                               value="{{ old('email') }}" placeholder="email@example.com" required>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Phone Number</label>
                        <input type="text" name="phone" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                               value="{{ old('phone') }}" placeholder="+62 xxx xxxx xxxx">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Gender</label>
                        <select name="gender" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer">
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Birth Date</label>
                        <input type="date" name="birth_date" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" value="{{ old('birth_date') }}">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Birth Place</label>
                        <input type="text" name="birth_place" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" value="{{ old('birth_place') }}" placeholder="City, Country">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Address</label>
                        <textarea name="address" rows="3" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all resize-none" placeholder="Enter full address">{{ old('address') }}</textarea>
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
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="create_user_account" name="create_user_account" value="1" 
                               class="w-4 h-4 rounded border-slate-600 bg-slate-700 text-blue-600 focus:ring-blue-500/50 focus:ring-offset-0 transition-all"
                               {{ old('create_user_account') ? 'checked' : '' }}
                               onchange="togglePasswordFields()">
                        <label for="create_user_account" class="text-sm text-slate-300 font-medium cursor-pointer">Create user account for login</label>
                    </div>

                    <div id="password-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ old('create_user_account') ? '' : 'hidden' }}">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                Password <span class="text-red-400">*</span>
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
                const checkbox = document.getElementById('create_user_account');
                const fields = document.getElementById('password-fields');
                if (checkbox.checked) {
                    fields.classList.remove('hidden');
                } else {
                    fields.classList.add('hidden');
                }
            }
        </script>
        
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
                            Hire Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="hire_date" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('hire_date') border-red-500/50 @enderror" 
                               value="{{ old('hire_date', date('Y-m-d')) }}" required>
                        @error('hire_date')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Employment Type <span class="text-red-400">*</span>
                        </label>
                        <select name="employment_type" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer @error('employment_type') border-red-500/50 @enderror" required>
                            <option value="permanent" {{ old('employment_type') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="probation" {{ old('employment_type') == 'probation' ? 'selected' : '' }}>Probation</option>
                            <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        @error('employment_type')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">ID Number (KTP)</label>
                        <input type="text" name="id_number" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" value="{{ old('id_number') }}" placeholder="16 digits">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tax Number (NPWP)</label>
                        <input type="text" name="tax_number" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" value="{{ old('tax_number') }}" placeholder="15 digits">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Bank Name</label>
                        <input type="text" name="bank_name" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" value="{{ old('bank_name') }}" placeholder="e.g., BCA, Mandiri">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Bank Account Number</label>
                        <input type="text" name="bank_account" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" value="{{ old('bank_account') }}" placeholder="Account number">
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Assignment Information --}}
        <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-blue-400"></i>
                    Work Assignment
                </h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2 relative" id="organization-multiselect">
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                Organizations <span class="text-red-400">*</span>
                            </label>
                            
                            <button type="button" onclick="toggleOrganizationDropdown()" class="w-full h-10 px-3.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-left text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all flex items-center justify-between">
                                <span id="organization-selection-text" class="text-slate-500">Select organizations...</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                            </button>

                            <div id="organization-dropdown-menu" class="hidden absolute z-10 w-full mt-1 bg-slate-800 border border-slate-700 rounded-lg shadow-xl max-h-60 overflow-y-auto p-1">
                                @foreach($organizations as $org)
                                    <label class="flex items-center gap-2 px-3 py-2 hover:bg-slate-700/50 rounded cursor-pointer group">
                                        <input 
                                            type="checkbox" 
                                            name="organization_ids[]" 
                                            value="{{ $org->id }}" 
                                            class="w-4 h-4 rounded border-slate-600 bg-slate-700 text-blue-600 focus:ring-blue-500/50 focus:ring-offset-0 transition-all"
                                            onchange="updateOrganizationSelection()"
                                            {{ in_array($org->id, old('organization_ids', [])) ? 'checked' : '' }}
                                        >
                                        <span class="text-sm text-slate-300 group-hover:text-white transition-colors">{{ $org->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            
                            @error('organization_ids')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            function toggleOrganizationDropdown() {
                                document.getElementById('organization-dropdown-menu').classList.toggle('hidden');
                            }

                            function updateOrganizationSelection() {
                                const checkboxes = document.querySelectorAll('input[name="organization_ids[]"]:checked');
                                const textSpan = document.getElementById('organization-selection-text');
                                
                                if (checkboxes.length === 0) {
                                    textSpan.textContent = 'Select organizations...';
                                    textSpan.classList.add('text-slate-500');
                                    textSpan.classList.remove('text-white');
                                } else {
                                    textSpan.textContent = `${checkboxes.length} Organization${checkboxes.length > 1 ? 's' : ''} Selected`;
                                    textSpan.classList.remove('text-slate-500');
                                    textSpan.classList.add('text-white');
                                }
                            }

                            // Close dropdown when clicking outside
                            document.addEventListener('click', function(event) {
                                const dropdown = document.getElementById('organization-multiselect');
                                const menu = document.getElementById('organization-dropdown-menu');
                                if (!dropdown.contains(event.target)) {
                                    menu.classList.add('hidden');
                                }
                            });
                        </script>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Department</label>
                        <select name="department_id" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer">
                            <option value="">Select department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->organization->name }} - {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Position</label>
                        <select name="position_id" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer">
                            <option value="">Select position</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Supervisor</label>
                        <select name="supervisor_id" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer">
                            <option value="">Select supervisor</option>
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
        <div class="flex items-center justify-end gap-3 pb-6">
            <a href="{{ route('employees.index') }}" class="px-5 py-2.5 bg-slate-800/50 border border-slate-700/50 text-slate-300 hover:bg-slate-800 hover:text-white hover:border-slate-600 rounded-lg text-sm font-medium transition-all">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium transition-all shadow-sm inline-flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                Create Employee
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
