@extends('layouts.app')

@section('title', 'Edit Organization')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header with Back Button --}}
    <div>
        <a href="{{ route('organizations.index') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm inline-flex items-center gap-2 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back to Organizations</span>
        </a>
        <h1 class="text-2xl font-semibold text-white mb-1">Edit Organization</h1>
        <p class="text-slate-400 text-sm">Update organization details and settings</p>
    </div>
    
    <form method="POST" action="{{ route('organizations.update', $organization) }}" class="space-y-5">
        @csrf
        @method('PUT')
        
        {{-- Organization Identity --}}
        <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i data-lucide="building-2" class="w-4 h-4 text-blue-400"></i>
                    Organization Details
                </h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Organization Code <span class="text-red-400">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="code" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('code') border-red-500/50 @enderror" 
                            value="{{ old('code', $organization->code) }}" 
                            placeholder="e.g., HO-001" 
                            required
                        >
                        @error('code')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Organization Name <span class="text-red-400">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all @error('name') border-red-500/50 @enderror" 
                            value="{{ old('name', $organization->name) }}" 
                            placeholder="Enter organization name" 
                            required
                        >
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Type <span class="text-red-400">*</span>
                        </label>
                        <select 
                            name="type" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer @error('type') border-red-500/50 @enderror" 
                            required
                        >
                            <option value="">Select type</option>
                            <option value="yayasan" {{ old('type', $organization->type) == 'yayasan' ? 'selected' : '' }}>Yayasan</option>
                            <option value="unit" {{ old('type', $organization->type) == 'unit' ? 'selected' : '' }}>Unit</option>
                            <option value="cabang" {{ old('type', $organization->type) == 'cabang' ? 'selected' : '' }}>Cabang</option>
                        </select>
                        @error('type')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Parent Organization</label>
                        <select 
                            name="parent_id" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all cursor-pointer"
                        >
                            <option value="">None (Top Level)</option>
                            @foreach($parentOrganizations as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $organization->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                        <div class="flex items-center gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input 
                                    type="radio" 
                                    name="is_active" 
                                    value="1" 
                                    class="w-4 h-4 text-blue-600 bg-slate-800 border-slate-700 focus:ring-blue-500 focus:ring-offset-slate-900"
                                    {{ old('is_active', $organization->is_active) ? 'checked' : '' }}
                                >
                                <span class="text-sm text-slate-300">Active</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input 
                                    type="radio" 
                                    name="is_active" 
                                    value="0" 
                                    class="w-4 h-4 text-blue-600 bg-slate-800 border-slate-700 focus:ring-blue-500 focus:ring-offset-slate-900"
                                    {{ old('is_active', $organization->is_active) ? '' : 'checked' }}
                                >
                                <span class="text-sm text-slate-300">Inactive</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Contact Information --}}
        <div class="bg-slate-900/90 backdrop-blur-sm rounded-xl border border-slate-700/50 shadow-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-blue-400"></i>
                    Contact & Location
                </h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                            value="{{ old('email', $organization->email) }}" 
                            placeholder="organization@example.com"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Phone Number</label>
                        <input 
                            type="text" 
                            name="phone" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all" 
                            value="{{ old('phone', $organization->phone) }}" 
                            placeholder="+62 xxx xxxx xxxx"
                        >
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Address</label>
                        <textarea 
                            name="address" 
                            rows="3" 
                            class="w-full px-3.5 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500/50 transition-all resize-none" 
                            placeholder="Enter full address"
                        >{{ old('address', $organization->address) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Form Actions --}}
        <div class="flex items-center justify-end gap-3 pb-6">
            <a href="{{ route('organizations.index') }}" class="px-5 py-2.5 bg-slate-800/50 border border-slate-700/50 text-slate-300 hover:bg-slate-800 hover:text-white hover:border-slate-600 rounded-lg text-sm font-medium transition-all">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium transition-all shadow-sm inline-flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Save Changes
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
