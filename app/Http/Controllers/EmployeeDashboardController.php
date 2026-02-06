<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\News;
use Carbon\Carbon;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
        
        if (!$employee) {
            abort(403, 'Please log in to access this dashboard.');
        }

        // Load relationships
        $employee->load(['primaryAssignment.organization', 'primaryAssignment.department', 'primaryAssignment.position', 'activeAssignments']);
        
        $assignment = $employee->primaryAssignment;
        
        // Calculate stats for this month
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        
        $monthlyAttendance = collect();
        if ($assignment) {
            $monthlyAttendance = Attendance::where('assignment_id', $assignment->id)
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->get();
        }
        
        $presentCount = $monthlyAttendance->where('status', 'present')->count();
        $lateCount = $monthlyAttendance->where('status', 'late')->count();
        $totalWorked = $presentCount + $lateCount;
        
        // Calculate attendance rate
        $workingDaysPassed = now()->diffInWeekdays($monthStart) + 1;
        $attendanceRate = $workingDaysPassed > 0 
            ? round(($totalWorked / $workingDaysPassed) * 100) . '%' 
            : '100%';
        
        $stats = [
            'leave_balance' => 12, // Placeholder
            'attendance_rate' => $attendanceRate,
            'days_worked' => $totalWorked,
            'late_count' => $lateCount,
        ];
        
        // Get recent news for this employee
        $recentNews = News::published()
            ->forEmployee($employee)
            ->orderByPinned()
            ->take(5)
            ->get();

        return view('dashboard.employee', compact(
            'employee', 
            'stats', 
            'recentNews'
        ));
    }
}
