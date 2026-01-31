<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use App\Models\Assignment;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Seed the organization structure.
     */
    public function run(): void
    {
        // Create branches
        $yayasan = Branch::create([
            'code' => 'YYS',
            'name' => 'Yayasan',
            'type' => 'yayasan',
            'is_active' => true,
        ]);

        $malaka = Branch::create([
            'code' => 'MLK',
            'name' => 'Malaka',
            'type' => 'unit',
            'parent_id' => $yayasan->id,
            'is_active' => true,
        ]);

        $itbu = Branch::create([
            'code' => 'ITBU',
            'name' => 'ITBU',
            'type' => 'unit',
            'parent_id' => $yayasan->id,
            'is_active' => true,
        ]);

        // Create departments for each branch
        foreach ([$yayasan, $malaka, $itbu] as $branch) {
            Department::create([
                'branch_id' => $branch->id,
                'code' => 'HRD',
                'name' => 'Human Resources',
                'is_active' => true,
            ]);

            Department::create([
                'branch_id' => $branch->id,
                'code' => 'FIN',
                'name' => 'Finance',
                'is_active' => true,
            ]);

            Department::create([
                'branch_id' => $branch->id,
                'code' => 'OPS',
                'name' => 'Operations',
                'is_active' => true,
            ]);

            Department::create([
                'branch_id' => $branch->id,
                'code' => 'IT',
                'name' => 'Information Technology',
                'is_active' => true,
            ]);
        }

        // Create positions
        $positions = [
            ['code' => 'DIR', 'name' => 'Director', 'level' => 6],
            ['code' => 'MGR', 'name' => 'Manager', 'level' => 4],
            ['code' => 'SPV', 'name' => 'Supervisor', 'level' => 3],
            ['code' => 'SR-STAFF', 'name' => 'Senior Staff', 'level' => 2],
            ['code' => 'STAFF', 'name' => 'Staff', 'level' => 1],
            ['code' => 'HR-MGR', 'name' => 'HR Manager', 'level' => 4],
            ['code' => 'HR-STAFF', 'name' => 'HR Staff', 'level' => 1],
            ['code' => 'FIN-MGR', 'name' => 'Finance Manager', 'level' => 4],
            ['code' => 'ACCT', 'name' => 'Accountant', 'level' => 2],
            ['code' => 'IT-MGR', 'name' => 'IT Manager', 'level' => 4],
            ['code' => 'DEV', 'name' => 'Developer', 'level' => 2],
        ];

        foreach ($positions as $pos) {
            Position::create([
                'code' => $pos['code'],
                'name' => $pos['name'],
                'level' => $pos['level'],
                'is_active' => true,
            ]);
        }

        $this->command->info('Organization structure seeded successfully!');
    }
}
