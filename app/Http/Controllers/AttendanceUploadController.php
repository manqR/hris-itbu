<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceUploadController extends Controller
{
    public function show()
    {
        return view('attendance.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data); // Remove header row if exists? 
        // Let's assume header exists if the first row contains "employee"
        if (isset($header[0]) && stripos($header[0], 'employee') === false) {
             // If first row is not header, put it back
             array_unshift($data, $header);
        }

        $count = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($data as $row) {
                if (count($row) < 4) continue;

                // Format: EmployeeNumber, Date, In, Out
                $empNo = trim($row[0]);
                $date = trim($row[1]);
                $in = trim($row[2]);
                $out = trim($row[3]);

                if (empty($empNo) || empty($date)) continue;

                $employee = Employee::where('employee_number', $empNo)->first();
                
                if (!$employee) {
                    $errors[] = "Employee not found: $empNo";
                    continue;
                }

                $assignment = $employee->primaryAssignment;
                if (!$assignment) {
                     $errors[] = "No active assignment for: $empNo";
                     continue;
                }

                // Check for existing
                $existing = Attendance::where('assignment_id', $assignment->id)
                    ->where('date', $date)
                    ->first();

                if ($existing) {
                    // Update if overwrite logic needed, else skip or update
                    $existing->update([
                        'clock_in_time' => $in ? "$date $in" : null,
                        'clock_out_time' => $out ? "$date $out" : null,
                        'source' => 'manual_upload',
                        'status' => 'present', 
                    ]);
                } else {
                    Attendance::create([
                        'assignment_id' => $assignment->id,
                        'date' => $date,
                        'clock_in_time' => $in ? "$date $in" : null,
                        'clock_out_time' => $out ? "$date $out" : null,
                        'status' => 'present',
                        'source' => 'manual_upload',
                    ]);
                }
                $count++;
            }
            
            DB::commit();
            
            if (count($errors) > 0) {
                 return back()->with('success', "Imported $count records.")->with('import_errors', $errors);
            }
            
            return back()->with('success', "Successfully imported $count records.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
