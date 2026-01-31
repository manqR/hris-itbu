<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display the attendance dashboard/history.
     */
    public function index(Request $request)
    {
        $assignments = auth()->user()->employee->activeAssignments;
        
        $selectedAssignmentId = $request->assignment_id ?? $assignments->first()?->id;
        
        $attendances = Attendance::where('assignment_id', $selectedAssignmentId)
            ->whereMonth('date', Carbon::now()->month)
            ->orderBy('date', 'desc')
            ->get();
            
        // Check for today's attendance
        $todayAttendance = Attendance::where('assignment_id', $selectedAssignmentId)
            ->where('date', Carbon::today())
            ->first();

        return view('attendance.index', compact('assignments', 'attendances', 'todayAttendance', 'selectedAssignmentId'));
    }

    /**
     * Clock In.
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Verify ownership
        $assignment = Assignment::findOrFail($request->assignment_id);
        if ($assignment->employee_id !== auth()->user()->employee->id) {
            abort(403, 'Unauthorized');
        }

        // Check if already clocked in
        $existing = Attendance::where('assignment_id', $assignment->id)
            ->where('date', Carbon::today())
            ->first();

        if ($existing) {
            return back()->with('error', 'Already clocked in for today.');
        }

        Attendance::create([
            'assignment_id' => $assignment->id,
            'date' => Carbon::today(),
            'clock_in_time' => Carbon::now(),
            'status' => 'present',
            'latitude_in' => $request->latitude,
            'longitude_in' => $request->longitude,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Clocked in successfully at ' . Carbon::now()->format('H:i'));
    }

    /**
     * Clock Out.
     */
    public function clockOut(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $attendance = Attendance::where('assignment_id', $request->assignment_id)
            ->where('date', Carbon::today())
            ->firstOrFail();

        if ($attendance->clock_out_time) {
            return back()->with('error', 'Already clocked out.');
        }

        $attendance->update([
            'clock_out_time' => Carbon::now(),
            'latitude_out' => $request->latitude,
            'longitude_out' => $request->longitude,
            'notes' => $request->notes,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Clocked out successfully at ' . Carbon::now()->format('H:i'));
    }
}
