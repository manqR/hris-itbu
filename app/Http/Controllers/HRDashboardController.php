<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Position;
use Carbon\Carbon;

class HRDashboardController extends Controller
{
    public function index()
    {
        // Current stats
        $currentEmployees = Employee::active()->count();
        $currentOrganizations = Organization::active()->count();
        $currentDepartments = Department::active()->count();
        $currentPositions = Position::active()->count();
        
        // Previous month stats for growth calculation
        $lastMonth = Carbon::now()->subMonth();
        $previousEmployees = Employee::where('created_at', '<', $lastMonth)->count();
        
        // Calculate growth percentages
        $employeeGrowth = $previousEmployees > 0 
            ? round((($currentEmployees - $previousEmployees) / $previousEmployees) * 100, 1)
            : 0;
        
        // Stats for HR with growth indicators
        $stats = [
            'employees' => $currentEmployees,
            'employees_growth' => $employeeGrowth,
            'organizations' => $currentOrganizations,
            'departments' => $currentDepartments,
            'positions' => $currentPositions,
        ];
        
        // Recent employees (last 7 days)
        $recentEmployees = Employee::with(['activeAssignments.organization', 'activeAssignments.position'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();
            
        // Organization overview with employee counts
        $organizations = Organization::withCount(['activeAssignments as employees_count'])
            ->active()
            ->get();
            
        // Department distribution
        $departments = Department::withCount(['activeAssignments as employees_count'])
            ->active()
            ->orderByDesc('employees_count')
            ->take(5)
            ->get();

        return view('dashboard.hr', compact('stats', 'recentEmployees', 'organizations', 'departments'));
    }
}
