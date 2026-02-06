<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Employee;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // All permissions
        $permissions = [
            // Employee management
            'view_employees',
            'create_employee',
            'edit_employee',
            'delete_employee',
            
            // Attendance
            'view_attendance',
            'upload_attendance',
            
            // Leave/Permission
            'view_leaves',
            'create_leave',
            'approve_leave',
            
            // Duty Assignment (Surat Tugas)
            'view_duty_assignments',
            'create_duty_assignment',
            'approve_duty_assignment',
            
            // Master data management
            'manage_master_data', // Parent permission for all master data
            'manage_organizations',
            'manage_departments',
            'manage_positions',
            'manage_leave_types',
            'manage_menus',
            
            // System
            'audit_system',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles and their permissions
        
        // Super Admin - All permissions
        $superAdmin = Role::updateOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // HR Staff
        $hrStaff = Role::updateOrCreate(['name' => 'HR Staff', 'guard_name' => 'web']);
        $hrStaff->givePermissionTo([
            'view_employees',
            'create_employee',
            'edit_employee',
            'view_attendance',
            'upload_attendance',
            'view_leaves',
            'approve_leave',
            'view_duty_assignments',
            'create_duty_assignment',
            'manage_master_data',
            'manage_organizations',
            'manage_departments',
            'manage_positions',
            'manage_leave_types',
            'audit_system',
        ]);

        // Division Manager
        $manager = Role::updateOrCreate(['name' => 'Division Manager', 'guard_name' => 'web']);
        $manager->givePermissionTo([
            'view_employees',
            'view_attendance',
            'view_leaves',
            'approve_leave',
            'view_duty_assignments',
            'create_duty_assignment',
            'approve_duty_assignment',
        ]);

        // Employee
        $employee = Role::updateOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
        $employee->givePermissionTo([
            'create_leave', // Can request leave
        ]);

        // Assign Super Admin to existing Admin Employee
        $adminEmployee = Employee::where('email', 'admin@hris.test')->first();
        if ($adminEmployee) {
            $adminEmployee->assignRole($superAdmin);
            $this->command->info('Assigned Super Admin role to admin@hris.test');
        }
    }
}
