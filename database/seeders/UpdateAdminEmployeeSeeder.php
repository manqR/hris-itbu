<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Position;
use App\Models\Assignment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UpdateAdminEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@hris.test')->first();
        
        if (!$user) {
            $this->command->error('Admin user not found!');
            return;
        }

        // Get organizational units (assuming seeded by OrganizationSeeder)
        $branch = Branch::where('code', 'YYS')->first(); // Yayasan
        $position = Position::where('level', Position::LEVEL_DIRECTOR)->first(); 
        // If director not found, fallback to any staff
        if (!$position) {
             $position = Position::first();
        }
        
        $department = Department::where('branch_id', $branch->id)->first();

        if (!$branch || !$position) {
            $this->command->error('Organization data missing. Run OrganizationSeeder first.');
            return;
        }

        // Check if employee already exists for this user OR by employee number
        $employee = Employee::where('user_id', $user->id)
            ->orWhere('employee_number', 'EMP001')
            ->first();

        if (!$employee) {
            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_number' => 'EMP001',
                'name' => $user->name,
                'email' => $user->email,
                'gender' => 'male',
                'hire_date' => Carbon::parse('2024-01-01'),
                'employment_status' => 'active',
                'employment_type' => 'permanent',
                'is_active' => true,
                'created_by' => $user->id,
            ]);
            
            $this->command->info('Created Employee profile for Admin.');
        } else {
             // Link user if not linked
             if (!$employee->user_id) {
                 $employee->update(['user_id' => $user->id]);
                 $this->command->info('Linked existing Employee profile to Admin user.');
             } else {
                 $this->command->info('Employee profile already linked.');
             }
        }

        // Check for active assignment
        $assignment = Assignment::where('employee_id', $employee->id)
            ->where('is_primary', true)
            ->where('status', 'active')
            ->first();

        if (!$assignment) {
            Assignment::create([
                'employee_id' => $employee->id,
                'branch_id' => $branch->id,
                'department_id' => $department?->id,
                'position_id' => $position->id,
                'start_date' => Carbon::parse('2024-01-01'),
                'is_primary' => true,
                'status' => 'active',
                'created_by' => $user->id,
            ]);
            
            $this->command->info('Created primary assignment for Admin.');
        } else {
             $this->command->info('Primary assignment already exists.');
        }
    }
}
