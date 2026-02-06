<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

/**
 * Menu Service
 * 
 * Handles building and caching menu trees for users based on permissions.
 */
class MenuService
{
    /**
     * Get the menu tree for a user
     */
    public static function getMenuForUser($user): array
    {
        if (!$user) {
            return self::getPublicMenu();
        }

        // Cache per user for 30 minutes
        $cacheKey = 'user_menu_' . $user->id;
        
        return Cache::remember($cacheKey, 1800, function () use ($user) {
            return self::buildMenuTree($user);
        });
    }

    /**
     * Get menu items accessible to unauthenticated users
     */
    public static function getPublicMenu(): array
    {
        return Menu::active()
            ->topLevel()
            ->whereNull('permission')
            ->orderBy('order')
            ->get()
            ->toArray();
    }

    /**
     * Build the complete menu tree for a user
     */
    private static function buildMenuTree($user): array
    {
        $menus = Menu::active()
            ->topLevel()
            ->withActiveChildren()
            ->orderBy('order')
            ->get();

        return self::filterMenusForUser($menus, $user);
    }

    /**
     * Filter menus based on user permissions
     */
    private static function filterMenusForUser($menus, $user): array
    {
        $result = [];

        foreach ($menus as $menu) {
            // Check if user can access this menu
            if (!$menu->isAccessibleBy($user)) {
                // If this is a parent menu, check if any children are accessible
                if ($menu->activeChildren->isEmpty() || !$menu->hasAccessibleChildren($user)) {
                    continue;
                }
            }

            $menuData = [
                'id' => $menu->id,
                'name' => $menu->name,
                'icon' => $menu->icon,
                'route' => $menu->route,
                'url' => self::safeRoute($menu->route),
                'permission' => $menu->permission,
                'is_active' => $menu->isActive(),
                'children' => [],
            ];

            // Process children
            if ($menu->activeChildren->isNotEmpty()) {
                foreach ($menu->activeChildren as $child) {
                    if ($child->isAccessibleBy($user)) {
                        $menuData['children'][] = [
                            'id' => $child->id,
                            'name' => $child->name,
                            'icon' => $child->icon,
                            'route' => $child->route,
                            'url' => self::safeRoute($child->route),
                            'permission' => $child->permission,
                            'is_active' => $child->isActive(),
                        ];
                    }
                }
            }

            $result[] = $menuData;
        }

        return $result;
    }

    /**
     * Safely generate a route URL, returning '#' if route doesn't exist
     */
    private static function safeRoute(?string $routeName): string
    {
        if (empty($routeName)) {
            return '#';
        }

        try {
            return route($routeName);
        } catch (\Exception $e) {
            return '#';
        }
    }

    /**
     * Clear menu cache for a user
     */
    public static function clearCacheForUser($user): void
    {
        if ($user) {
            Cache::forget('user_menu_' . $user->id);
        }
    }

    /**
     * Clear all menu caches
     */
    public static function clearAllCache(): void
    {
        // In production, you'd want a more targeted cache clear
        Cache::flush();
    }
}
