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

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Dedicated Dashboards
    Route::get('/dashboard/hr', [App\Http\Controllers\HRDashboardController::class, 'index'])->name('hr.dashboard');
    Route::get('/dashboard/employee', [App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');

    // Employees
    Route::resource('employees', EmployeeController::class);
    
    // Employee Assignments
    Route::post('/employees/{employee}/assignments', [App\Http\Controllers\AssignmentController::class, 'store'])->name('employees.assignments.store');
    Route::put('/employees/{employee}/assignments/{assignment}', [App\Http\Controllers\AssignmentController::class, 'update'])->name('employees.assignments.update');
    Route::delete('/employees/{employee}/assignments/{assignment}', [App\Http\Controllers\AssignmentController::class, 'destroy'])->name('employees.assignments.destroy');

    // Organization
    Route::resource('organizations', App\Http\Controllers\OrganizationController::class);
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);
    Route::resource('positions', App\Http\Controllers\PositionController::class);
    
    // Menu Management
    Route::resource('menus', App\Http\Controllers\MenuController::class);
    Route::post('/menus/reorder', [App\Http\Controllers\MenuController::class, 'reorder'])->name('menus.reorder');
    Route::patch('/menus/{menu}/toggle', [App\Http\Controllers\MenuController::class, 'toggle'])->name('menus.toggle');

    // Attendance
    Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/upload', [App\Http\Controllers\AttendanceUploadController::class, 'show'])->name('attendance.upload');
    Route::post('/attendance/upload', [App\Http\Controllers\AttendanceUploadController::class, 'store'])->name('attendance.upload.store');
    // Organization Context
    Route::post('/organization/switch', [App\Http\Controllers\OrganizationContextController::class, 'switch'])->name('organization.switch');

    Route::post('/attendance/clock-in', [App\Http\Controllers\AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [App\Http\Controllers\AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Temporary Login Route for Verification (to be removed)
// Route::get('/test-login', function () {
//     auth()->loginUsingId(1);
//     return redirect()->route('dashboard');
// });
