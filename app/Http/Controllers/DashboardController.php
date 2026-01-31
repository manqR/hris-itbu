<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin') || $user->hasRole('HR Staff')) {
            return redirect()->action([HRDashboardController::class, 'index']);
        }
        
        if ($user->hasRole('Employee')) {
            return redirect()->action([EmployeeDashboardController::class, 'index']);
        }
        
        // Default fallback (or unauthorized)
        return redirect()->action([EmployeeDashboardController::class, 'index']);
    }
}
