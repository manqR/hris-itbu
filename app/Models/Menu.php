<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Menu Model
 * 
 * Database-driven menu system with hierarchical structure and permission-based access.
 */
class Menu extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'icon',
        'route',
        'url',
        'permission',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Parent menu relationship
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Child menus relationship
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Active children only
     */
    public function activeChildren(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Scope for active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for top-level menus (no parent)
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope with active children preloaded
     */
    public function scopeWithActiveChildren($query)
    {
        return $query->with(['activeChildren' => function ($q) {
            $q->with('activeChildren'); // Support 2 levels deep
        }]);
    }

    /**
     * Check if this menu is accessible by a user
     */
    public function isAccessibleBy($user): bool
    {
        // No permission required = accessible to all
        if (empty($this->permission)) {
            return true;
        }

        // Check user permission
        return $user && $user->can($this->permission);
    }

    /**
     * Check if menu has accessible children for user
     */
    public function hasAccessibleChildren($user): bool
    {
        foreach ($this->activeChildren as $child) {
            if ($child->isAccessibleBy($user)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the URL for this menu item
     */
    public function getUrlAttribute(): ?string
    {
        if ($this->route) {
            try {
                return route($this->route);
            } catch (\Exception $e) {
                return '#';
            }
        }
        return $this->attributes['url'] ?? '#';
    }

    /**
     * Check if this menu or any of its children is currently active
     */
    public function isActive(): bool
    {
        // Check if route matches current
        if ($this->route && request()->routeIs($this->route . '*')) {
            return true;
        }

        // Check children
        foreach ($this->activeChildren as $child) {
            if ($child->isActive()) {
                return true;
            }
        }

        return false;
    }
}
