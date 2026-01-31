<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view_all_employees',
            'create_employee',
            'edit_employee',
            'delete_employee',
            'upload_attendance',
            'view_all_attendance',
            'approve_leave',
            'view_any_leave',
            'audit_system',
            'create_surat_tugas',
            'clock_in_self_service', // Optional: for field employees
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Roles
        $superAdmin = Role::updateOrCreate(['name' => 'Super Admin']);
        // Super Admin gets all permissions via Gate logic usually, but we can also assign all
        $superAdmin->givePermissionTo(Permission::all());

        $hrStaff = Role::updateOrCreate(['name' => 'HR Staff']);
        $hrStaff->givePermissionTo([
            'view_all_employees',
            'create_employee',
            'edit_employee',
            'upload_attendance',
            'view_all_attendance',
            'view_any_leave',
            'audit_system',
            'create_surat_tugas',
        ]);

        $manager = Role::updateOrCreate(['name' => 'Division Manager']);
        $manager->givePermissionTo([
            'view_all_employees', 
            'approve_leave',
            'create_surat_tugas',
        ]);

        $employee = Role::updateOrCreate(['name' => 'Employee']);
        // Standard employees do NOT get clock_in_self_service by default now
        // They only get basic view access (handled by app logic or basic perms)

        // Assign Super Admin to existing Admin User
        $adminUser = User::where('email', 'admin@hris.test')->first();
        if ($adminUser) {
            $adminUser->assignRole($superAdmin);
            $this->command->info('Assigned Super Admin role to admin@hris.test');
        }
    }
}
