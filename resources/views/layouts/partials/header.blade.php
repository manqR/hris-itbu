{{-- Top Header --}}
<header class="top-header">
    <div class="header-left">
        {{-- Mobile menu toggle --}}
        <button type="button" class="btn btn-ghost hidden-lg" onclick="toggleSidebar()">
            <i data-lucide="menu" width="20" height="20"></i>
        </button>
        
        {{-- Breadcrumb --}}
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
            @yield('breadcrumb')
        </nav>
    </div>
    
    <div class="header-right">
        {{-- Notifications --}}
        <button type="button" class="btn btn-ghost" title="Notifications">
            <i data-lucide="bell" width="20" height="20"></i>
        </button>
        
        {{-- User Menu --}}
        <div class="header-user">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</header>
