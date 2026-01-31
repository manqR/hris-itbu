<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Position;

class HRDashboardController extends Controller
{
    public function index()
    {
        // Stats for HR
        $stats = [
            'employees' => Employee::active()->count(),
            'branches' => Branch::active()->count(),
            'departments' => Department::active()->count(),
            'positions' => Position::active()->count(),
        ];
        
        // Recent employees
        $recentEmployees = Employee::with(['activeAssignments.branch', 'activeAssignments.position'])
            ->latest()
            ->take(5)
            ->get();
            
        // Organization overview
        $branches = Branch::withCount(['activeAssignments as employees_count'])
            ->active()
            ->get();

        return view('dashboard.hr', compact('stats', 'recentEmployees', 'branches'));
    }
}
