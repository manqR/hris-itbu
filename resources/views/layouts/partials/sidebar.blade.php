{{-- Enterprise Sidebar Navigation --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span class="sidebar-logo">HRIS</span>
    </div>
    
    <nav class="sidebar-nav">
        {{-- Main Navigation --}}
        <div class="nav-section">
            <div class="nav-section-label">Main</div>
            
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="nav-item-icon"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        {{-- Employee Management --}}
        <div class="nav-section">
            <div class="nav-section-label">Employees</div>
            
            <a href="{{ route('employees.index') }}" class="nav-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <i data-lucide="users" class="nav-item-icon"></i>
                <span>All Employees</span>
            </a>
            
            <a href="#" class="nav-item">
                <i data-lucide="user-plus" class="nav-item-icon"></i>
                <span>Add Employee</span>
            </a>
        </div>
        
        {{-- Organization --}}
        <div class="nav-section">
            <div class="nav-section-label">Organization</div>
            
            <a href="{{ route('branches.index') }}" class="nav-item {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                <i data-lucide="building-2" class="nav-item-icon"></i>
                <span>Branches</span>
            </a>
            
            <a href="{{ route('departments.index') }}" class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <i data-lucide="network" class="nav-item-icon"></i>
                <span>Departments</span>
            </a>
            
            <a href="{{ route('positions.index') }}" class="nav-item {{ request()->routeIs('positions.*') ? 'active' : '' }}">
                <i data-lucide="briefcase" class="nav-item-icon"></i>
                <span>Positions</span>
            </a>
        </div>
        
        {{-- Attendance & Leave --}}
        <div class="nav-section">
            <div class="nav-section-label">Attendance</div>
            
            <a href="{{ route('attendance.index') }}" class="nav-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <i data-lucide="clock" class="nav-item-icon"></i>
                <span>Attendance</span>
            </a>
            
            <a href="#" class="nav-item">
                <i data-lucide="calendar-off" class="nav-item-icon"></i>
                <span>Leave Requests</span>
            </a>
        </div>
        
        {{-- Reports --}}
        <div class="nav-section">
            <div class="nav-section-label">Reports</div>
            
            <a href="#" class="nav-item">
                <i data-lucide="bar-chart-3" class="nav-item-icon"></i>
                <span>Reports</span>
            </a>
            
            <a href="#" class="nav-item">
                <i data-lucide="scroll-text" class="nav-item-icon"></i>
                <span>Audit Log</span>
            </a>
        </div>
        
        {{-- Settings --}}
        <div class="nav-section">
            <div class="nav-section-label">Settings</div>
            
            <a href="#" class="nav-item">
                <i data-lucide="settings" class="nav-item-icon"></i>
                <span>Settings</span>
            </a>
        </div>
    </nav>
</aside>
