<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menus
        Menu::truncate();

        // Define menu structure
        $menus = [
            [
                'name' => 'Dashboard',
                'icon' => 'layout-dashboard',
                'route' => 'dashboard',
                'permission' => null, // All users
                'order' => 1,
            ],
            [
                'name' => 'Employee',
                'icon' => 'users',
                'route' => 'employees.index',
                'permission' => 'view_employees',
                'order' => 2,
            ],
            [
                'name' => 'Leave',
                'icon' => 'calendar-check',
                'route' => 'leaves.index',
                'permission' => 'view_leaves',
                'order' => 3,
            ],
            [
                'name' => 'Attendance',
                'icon' => 'clock',
                'route' => 'attendance.index',
                'permission' => 'view_attendance',
                'order' => 4,
            ],
            [
                'name' => 'News',
                'icon' => 'newspaper',
                'route' => 'news.index',
                'permission' => null, // All users
                'order' => 5,
            ],
            [
                'name' => 'My Profile',
                'icon' => 'user',
                'route' => 'employees.show',
                'permission' => null, // All users
                'order' => 6,
            ],
            [
                'name' => 'Duty Assignment',
                'icon' => 'file-signature',
                'route' => 'duty-assignments.index',
                'permission' => 'view_duty_assignments',
                'order' => 7,
            ],
            [
                'name' => 'Master Data',
                'icon' => 'database',
                'route' => null, // Parent menu, no route
                'permission' => 'manage_master_data',
                'order' => 8,
                'children' => [
                    [
                        'name' => 'Organization',
                        'icon' => 'building-2',
                        'route' => 'organizations.index',
                        'permission' => 'manage_organizations',
                        'order' => 1,
                    ],
                    [
                        'name' => 'Department',
                        'icon' => 'network',
                        'route' => 'departments.index',
                        'permission' => 'manage_departments',
                        'order' => 2,
                    ],
                    [
                        'name' => 'Position',
                        'icon' => 'briefcase',
                        'route' => 'positions.index',
                        'permission' => 'manage_positions',
                        'order' => 3,
                    ],
                    [
                        'name' => 'Leave Type',
                        'icon' => 'list-check',
                        'route' => 'leave-types.index',
                        'permission' => 'manage_leave_types',
                        'order' => 4,
                    ],
                    [
                        'name' => 'Menu Management',
                        'icon' => 'menu',
                        'route' => 'menus.index',
                        'permission' => 'manage_menus',
                        'order' => 5,
                    ],
                ],
            ],
        ];

        // Create menus
        foreach ($menus as $menuData) {
            $this->createMenu($menuData);
        }

        $this->command->info('Menus seeded successfully!');
    }

    /**
     * Create a menu and its children recursively
     */
    private function createMenu(array $data, ?int $parentId = null): void
    {
        $children = $data['children'] ?? [];
        unset($data['children']);

        $data['parent_id'] = $parentId;
        $data['is_active'] = true;

        $menu = Menu::create($data);

        foreach ($children as $childData) {
            $this->createMenu($childData, $menu->id);
        }
    }
}
