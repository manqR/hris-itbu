<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'code' => 'AL',
                'name' => 'Annual Leave',
                'days_allocated' => 12,
                'requires_file' => false,
            ],
            [
                'code' => 'SL',
                'name' => 'Sick Leave',
                'days_allocated' => 14, // Common standard, adjustable
                'requires_file' => true,
            ],
            [
                'code' => 'ML',
                'name' => 'Maternity Leave',
                'days_allocated' => 90,
                'requires_file' => true,
            ],
            [
                'code' => 'PL',
                'name' => 'Paternity Leave',
                'days_allocated' => 3,
                'requires_file' => true,
            ],
            [
                'code' => 'UL',
                'name' => 'Unpaid Leave',
                'days_allocated' => 0,
                'requires_file' => false,
            ],
             [
                'code' => 'CBA',
                'name' => 'Cross Branch Assignment',
                'days_allocated' => 0,
                'requires_file' => false,
            ],
        ];

        foreach ($types as $type) {
            LeaveType::updateOrCreate(
                ['code' => $type['code']],
                [
                    'name' => $type['name'],
                    'days_allocated' => $type['days_allocated'],
                    'requires_file' => $type['requires_file'],
                    'is_active' => true,
                ]
            );
        }
        
        $this->command->info('Leave types seeded successfully.');
    }
}
