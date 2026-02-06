<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class AdminEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::updateOrCreate(
            ['email' => 'admin@hris.local'],
            [
                'employee_number' => 'ADM001',
                'name' => 'System Administrator',
                'email' => 'admin@hris.local',
                'password' => 'admin', // Will be auto-hashed by model cast
                'phone' => null,
                'gender' => null,
                'hire_date' => now(),
                'employment_status' => 'active',
                'employment_type' => 'permanent',
                'is_active' => true,
            ]
        );

        $this->command->info('Admin employee created!');
        $this->command->info('Email: admin@hris.local');
        $this->command->info('Password: admin');
    }
}
