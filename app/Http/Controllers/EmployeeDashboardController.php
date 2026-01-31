<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        
        if (!$employee) {
            abort(403, 'Employee profile not found.');
        }

        $assignment = $employee->primaryAssignment;
        
        // Stats for Employee
        $stats = [
            'leave_balance' => 12, // Placeholder
            'attendance_rate' => '100%',
        ];
        
        // My recent attendance
        $recentAttendance = Attendance::where('assignment_id', $assignment?->id)
            ->latest('date')
            ->take(5)
            ->get();
            
        // My leave requests
        // $recentLeaves = ...

        return view('dashboard.employee', compact('employee', 'stats', 'recentAttendance'));
    }
}
