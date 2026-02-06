@extends('layouts.app')

@section('title', $employee->name)

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center text-3xl font-bold text-white shadow-lg shadow-blue-900/20">
                {{ strtoupper(substr($employee->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight mb-1">{{ $employee->name }}</h1>
                <div class="flex items-center gap-3 text-sm text-slate-400">
                    <span class="font-mono bg-slate-800/50 px-2 py-0.5 rounded border border-slate-700/50">{{ $employee->employee_number }}</span>
                    <span>•</span>
                    <span>{{ $employee->email }}</span>
                    <span>•</span>
                    <span class="{{ $employee->employment_status === 'active' ? 'text-emerald-400' : 'text-slate-400' }}">
                        {{ ucfirst($employee->employment_status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-slate-800/50 border border-slate-700/50 text-slate-300 hover:bg-slate-800 hover:text-white hover:border-slate-600 rounded-lg text-sm font-medium transition-all">
                Back to List
            </a>
            <a href="{{ route('employees.edit', $employee) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium transition-all shadow-sm inline-flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Edit Profile
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Left Column: Main Info --}}
        <div class="xl:col-span-2 space-y-6">
            {{-- Personal Information --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4 text-blue-400"></i>
                        Personal Information
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Gender</div>
                            <div class="text-sm text-white">{{ ucfirst($employee->gender ?? 'Not specified') }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Birth Date</div>
                            <div class="text-sm text-white">{{ $employee->birth_date?->format('d F Y') ?? 'Not specified' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Birth Place</div>
                            <div class="text-sm text-white">{{ $employee->birth_place ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Phone Number</div>
                            <div class="text-sm text-white font-mono">{{ $employee->phone ?? '-' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Address</div>
                            <div class="text-sm text-white">{{ $employee->address ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">ID Number (KTP)</div>
                            <div class="text-sm text-white font-mono">{{ $employee->id_number ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Tax Number (NPWP)</div>
                            <div class="text-sm text-white font-mono">{{ $employee->tax_number ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Assignment History --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="briefcase" class="w-4 h-4 text-blue-400"></i>
                        Assignment History
                    </h3>
                    <button type="button" onclick="document.getElementById('addAssignmentModal').classList.remove('hidden')" class="text-xs text-blue-400 hover:text-blue-300 font-medium transition-colors inline-flex items-center gap-1">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                        Add Assignment
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-800/30 border-b border-slate-700/50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Position & Organization</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Supervisor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($employee->assignments as $assignment)
                                <tr class="hover:bg-slate-800/20 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-white">{{ $assignment->position?->name ?? 'No Position' }}</span>
                                            <span class="text-xs text-slate-400">{{ $assignment->organization?->name ?? 'No Organization' }}</span>
                                            @if($assignment->is_primary)
                                                <span class="inline-flex mt-1 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 w-fit">Primary</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">
                                        {{ $assignment->department?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">
                                        {{ $assignment->supervisor?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">
                                        <div class="flex flex-col">
                                            <span>{{ $assignment->start_date->format('d M Y') }}</span>
                                            <span class="text-xs text-slate-500">
                                                to {{ $assignment->end_date?->format('d M Y') ?? 'Present' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($assignment->status === 'active')
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-800 text-slate-400 border border-slate-700">
                                                {{ ucfirst($assignment->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">
                                        No assignment history found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- History Timeline --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-blue-400"></i>
                        Activity Log
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        @forelse($employee->histories as $history)
                            <div class="relative pl-6 pb-2 border-l border-slate-700/50 last:border-0 last:pb-0">
                                <div class="absolute -left-[5px] top-1.5 w-2.5 h-2.5 rounded-full bg-slate-600 ring-4 ring-slate-900"></div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-medium text-white">{{ $history->change_type_label }}</span>
                                    <span class="text-xs text-slate-500">{{ $history->created_at->format('d M Y, H:i') }}</span>
                                    @if($history->notes)
                                        <p class="text-sm text-slate-400 mt-1 bg-slate-800/50 p-3 rounded-lg border border-slate-700/50">
                                            {{ $history->notes }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-slate-500 text-sm py-4">No activity history recorded yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Sidebar info --}}
        <div class="space-y-6">
            {{-- Employment Status Card --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="shield" class="w-4 h-4 text-blue-400"></i>
                        Employment Status
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Current Status</div>
                        @if($employee->employment_status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-sm font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-slate-800 text-slate-400 border border-slate-700">
                                {{ ucfirst($employee->employment_status) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Employment Type</div>
                        <div class="text-sm text-white">{{ ucfirst($employee->employment_type) }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Hire Date</div>
                        <div class="text-sm text-white">{{ $employee->hire_date->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Tenure</div>
                        <div class="text-sm text-white font-medium">{{ $employee->years_of_service }} Years</div>
                    </div>
                </div>
            </div>

            {{-- Bank Information Card --}}
            <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/30">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-4 h-4 text-blue-400"></i>
                        Bank Details
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Bank Name</div>
                        <div class="text-sm text-white">{{ $employee->bank_name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-1.5">Account Number</div>
                        <div class="text-sm text-white font-mono tracking-wider">{{ $employee->bank_account ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Add Assignment Modal --}}
<div id="addAssignmentModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700/50 rounded-2xl shadow-2xl w-full max-w-lg">
        <div class="px-6 py-4 border-b border-slate-700/50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-white">Add New Assignment</h3>
            <button type="button" onclick="document.getElementById('addAssignmentModal').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <form action="{{ route('employees.assignments.store', $employee) }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Organization <span class="text-red-400">*</span>
                </label>
                <select name="organization_id" required class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
                    <option value="">Select Organization</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}">{{ $org->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Department</label>
                <select name="department_id" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Position</label>
                <select name="position_id" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
                    <option value="">Select Position</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Supervisor</label>
                <select name="supervisor_id" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
                    <option value="">Select Supervisor</option>
                    @foreach($supervisors as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">
                    Start Date <span class="text-red-400">*</span>
                </label>
                <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_primary" name="is_primary" value="1" class="w-4 h-4 rounded border-slate-600 bg-slate-700 text-blue-600 focus:ring-blue-500/50">
                <label for="is_primary" class="text-sm text-slate-300">Set as Primary Assignment</label>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Notes</label>
                <textarea name="notes" rows="2" class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all resize-none" placeholder="Optional notes..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="document.getElementById('addAssignmentModal').classList.add('hidden')" class="px-4 py-2 bg-slate-800/50 border border-slate-700/50 text-slate-300 hover:bg-slate-800 rounded-lg text-sm font-medium transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium transition-all">
                    Add Assignment
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
