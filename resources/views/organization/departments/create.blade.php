@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header with Back Button --}}
    <div>
        <a href="{{ route('departments.index') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm inline-flex items-center gap-2 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back to Departments</span>
        </a>
        <h1 class="text-2xl font-semibold text-white mb-1">Add New Department</h1>
        <p class="text-slate-400 text-sm">Create a new organizational department or unit</p>
    </div>
    
    <form method="POST" action="{{ route('departments.store') }}" class="space-y-5">
        @csrf
        
        {{-- Department Details --}}
        <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i data-lucide="network" class="w-4 h-4 text-blue-400"></i>
                    Department Information
                </h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Organization Selection --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Organization <span class="text-red-400">*</span>
                        </label>
                        <select 
                            name="organization_id" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer @error('organization_id') border-red-500/50 @enderror" 
                            required
                        >
                            <option value="">Select organization</option>
                            @foreach($organizations as $org)
                                <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organization_id')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Department Code <span class="text-red-400">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="code" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('code') border-red-500/50 @enderror" 
                            value="{{ old('code') }}" 
                            placeholder="e.g., IT-001" 
                            required
                        >
                        @error('code')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Department Name <span class="text-red-400">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('name') border-red-500/50 @enderror" 
                            value="{{ old('name') }}" 
                            placeholder="Enter department name" 
                            required
                        >
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Parent Department</label>
                        <select 
                            name="parent_id" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer"
                        >
                            <option value="">None (Top Level)</option>
                            @foreach($parentDepartments as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Description</label>
                        <textarea 
                            name="description" 
                            rows="3" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all resize-none" 
                            placeholder="Brief description of the department's function"
                        >{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Form Actions --}}
        <div class="flex items-center justify-end gap-3 pb-6">
            <a href="{{ route('departments.index') }}" class="px-5 py-2.5 bg-slate-800/50 border border-slate-700/50 text-slate-300 hover:bg-slate-800 hover:text-white hover:border-slate-600 rounded-lg text-sm font-medium transition-all">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium transition-all shadow-sm inline-flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                Create Department
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
