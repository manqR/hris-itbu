<header class="h-16 bg-slate-900/80 backdrop-blur-md border-b border-slate-700/50 flex items-center justify-between px-8 sticky top-0 z-20">
    <div class="flex items-center gap-6">
        {{-- Mobile menu toggle --}}
        <button type="button" class="lg:hidden p-2 -ml-2 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-lg transition-colors" onclick="toggleSidebar()">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        
        {{-- Breadcrumb --}}
        <nav class="hidden md:flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-blue-400 transition-colors font-medium">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-600"></i>
            <span class="text-white font-medium">@yield('title', 'Dashboard')</span>
        </nav>
    </div>
    
    <div class="flex items-center gap-4">
        {{-- Search (Optional Visual) --}}
        <div class="hidden md:block relative">
             <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
             <input type="text" placeholder="Search..." class="pl-9 pr-4 py-1.5 bg-slate-800/50 border border-slate-700/50 rounded-full text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/50 w-64 transition-all">
        </div>

        <div class="h-8 w-px bg-slate-700/50 mx-2"></div>

        {{-- Organization Switcher --}}
        @if(isset($global_user_organizations) && $global_user_organizations->count() > 1)
            <div class="relative group" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    @click.outside="open = false"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/50 border border-slate-700/50 hover:bg-slate-800 transition-all"
                >
                    <i data-lucide="building-2" class="w-4 h-4 text-blue-400"></i>
                    <span class="text-xs font-medium text-slate-300">
                        {{ $global_active_organization?->name ?? 'Select Organization' }}
                    </span>
                    <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500"></i>
                </button>

                {{-- Dropdown Menu --}}
                <div 
                    x-show="open" 
                    x-transition
                    class="absolute right-0 top-full mt-2 w-48 bg-slate-800 border border-slate-700/50 rounded-lg shadow-xl py-1 z-50 hidden"
                    :class="{ 'hidden': !open }"
                >
                    <div class="px-3 py-2 border-b border-slate-700/50">
                        <span class="text-xs font-medium text-slate-400">Switch Organization</span>
                    </div>
                    
                    @foreach($global_user_organizations as $org)
                        <form action="{{ route('organization.switch') }}" method="POST">
                            @csrf
                            <input type="hidden" name="organization_id" value="{{ $org->id }}">
                            <button 
                                type="submit" 
                                class="w-full text-left px-3 py-2 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors flex items-center justify-between group/item"
                            >
                                <span>{{ $org->name }}</span>
                                @if($global_active_organization?->id === $org->id)
                                    <i data-lucide="check" class="w-3 h-3 text-blue-400"></i>
                                @endif
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
            
            <div class="h-8 w-px bg-slate-700/50 mx-2"></div>
        @endif

        {{-- Notifications --}}
        <button type="button" class="relative p-2 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-full transition-colors group">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-slate-900 group-hover:bg-red-400"></span>
        </button>
        
        {{-- User Menu --}}
        <div class="flex items-center gap-3 pl-2 cursor-pointer group">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-blue-500 text-white flex items-center justify-center font-bold text-xs shadow-lg group-hover:shadow-blue-500/30 transition-all">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
        </div>
    </div>
</header>
