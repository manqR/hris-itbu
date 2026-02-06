<aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-[#0B1120] text-slate-400 flex flex-col z-30 transition-transform duration-300 transform -translate-x-full lg:translate-x-0 border-r border-[#1e293b]">
    <!-- Brand Logo & Toggle -->
    <div class="h-20 flex items-center justify-between px-6 shrink-0">
        <div class="sidebar-brand">
            <div class="sidebar-brand-logo">H</div>
            <span class="sidebar-brand-text">HRMS</span>
        </div>
        
        <!-- Theme Toggle -->
        <button onclick="toggleTheme()" class="sidebar-theme-toggle" title="Toggle theme">
            <i data-lucide="sun" class="w-4 h-4 hidden dark-theme-icon"></i>
            <i data-lucide="moon" class="w-4 h-4 light-theme-icon"></i>
        </button>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-4 overflow-y-auto custom-scrollbar flex flex-col gap-1 py-4">
        
        @php
            $menuItems = \App\Services\MenuService::getMenuForUser(auth()->user());
        @endphp

        @foreach($menuItems as $item)
            @if(empty($item['children']))
                {{-- Single menu item --}}
                <a href="{{ $item['url'] }}" 
                   class="sidebar-menu-item {{ $item['is_active'] ? 'sidebar-menu-item--active' : '' }}">
                    <div class="sidebar-menu-icon">
                        <i data-lucide="{{ $item['icon'] ?? 'circle' }}" class="w-5 h-5"></i>
                    </div>
                    <span class="sidebar-menu-label">{{ $item['name'] }}</span>
                </a>
            @else
                {{-- Menu item with children (collapsible) --}}
                @php
                    $isParentActive = collect($item['children'])->contains('is_active', true);
                @endphp
                
                <div class="sidebar-menu-group" x-data="{ open: {{ $isParentActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="sidebar-menu-item sidebar-menu-group-btn {{ $isParentActive ? 'sidebar-menu-item--active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i data-lucide="{{ $item['icon'] ?? 'folder' }}" class="w-5 h-5"></i>
                        </div>
                        <span class="sidebar-menu-label">{{ $item['name'] }}</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 sidebar-menu-chevron" :class="{ 'sidebar-menu-chevron--open': open }"></i>
                    </button>
                    
                    {{-- Sub-menu items --}}
                    <div x-show="open" x-collapse class="sidebar-submenu">
                        @foreach($item['children'] as $child)
                            <a href="{{ $child['url'] }}" 
                               class="sidebar-submenu-item {{ $child['is_active'] ? 'sidebar-submenu-item--active' : '' }}">
                                <div class="sidebar-submenu-icon">
                                    <i data-lucide="{{ $child['icon'] ?? 'circle' }}" class="w-4 h-4"></i>
                                </div>
                                <span>{{ $child['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

    </nav>
    
    <!-- User Profile Card -->
    <div class="p-4 mt-auto shrink-0">
        <div class="sidebar-user-card">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                <div class="sidebar-user-status"></div>
            </div>
            
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="sidebar-user-email">{{ auth()->user()->email ?? 'user@company.com' }}</div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="sidebar-logout-btn" title="Logout">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="sidebar-overlay" onclick="closeSidebar()"></div>
