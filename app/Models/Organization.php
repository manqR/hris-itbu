<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Organization Model
 * 
 * Represents a business unit or location (formerly Branch).
 */
class Organization extends Model
{
    use BaseModel, SoftDeletes;

    protected $table = 'organizations';

    protected $fillable = [
        'code',
        'name',
        'address',
        'phone',
        'email',
        'is_head_office',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_head_office' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get departments in this organization.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all assignments in this organization.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get active assignments in this organization.
     */
    public function activeAssignments(): HasMany
    {
        return $this->assignments()->where('status', 'active');
    }

    /**
     * Scope to active organizations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
