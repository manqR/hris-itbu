<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * News Model
 * 
 * Company announcements, updates, and internal news
 */
class News extends Model
{
    use BaseModel, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'image',
        'type',
        'is_pinned',
        'is_published',
        'published_at',
        'created_by',
        'organization_id',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get type color for badge styling
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'announcement' => 'blue',
            'info' => 'slate',
            'event' => 'purple',
            'policy' => 'amber',
            'achievement' => 'emerald',
            default => 'slate',
        };
    }

    /**
     * Get type icon
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'announcement' => 'megaphone',
            'info' => 'info',
            'event' => 'calendar',
            'policy' => 'file-text',
            'achievement' => 'award',
            default => 'newspaper',
        };
    }

    /**
     * Scope for published news
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Scope for pinned news first
     */
    public function scopeOrderByPinned($query)
    {
        return $query->orderByDesc('is_pinned')->latest('published_at');
    }

    /**
     * Get accessible news for an employee
     */
    public function scopeForEmployee($query, $employee)
    {
        $organizationIds = $employee->activeAssignments->pluck('organization_id')->toArray();
        
        return $query->where(function ($q) use ($organizationIds) {
            $q->whereNull('organization_id') // Global news
                ->orWhereIn('organization_id', $organizationIds); // Org-specific
        });
    }

    /**
     * Author relationship
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    /**
     * Organization relationship
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
