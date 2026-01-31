<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Dedicated Dashboards
Route::get('/dashboard/hr', [App\Http\Controllers\HRDashboardController::class, 'index'])->name('hr.dashboard');
Route::get('/dashboard/employee', [App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');

// Employees
Route::resource('employees', EmployeeController::class);

// Organization
Route::resource('branches', BranchController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('positions', PositionController::class);

// Attendance
Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/attendance/upload', [App\Http\Controllers\AttendanceUploadController::class, 'show'])->name('attendance.upload');
Route::post('/attendance/upload', [App\Http\Controllers\AttendanceUploadController::class, 'store'])->name('attendance.upload.store');
Route::post('/attendance/clock-in', [App\Http\Controllers\AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
Route::post('/attendance/clock-out', [App\Http\Controllers\AttendanceController::class, 'clockOut'])->name('attendance.clock-out');

// Temporary Login Route for Verification
Route::get('/test-login', function () {
    auth()->loginUsingId(1);
    return redirect('/attendance');
});
