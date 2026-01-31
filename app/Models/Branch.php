<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Branch Model
 * 
 * Represents organizational units (Yayasan, Malaka, ITBU)
 */
class Branch extends Model
{
    use BaseModel;

    protected $fillable = [
        'code',
        'name',
        'type',
        'parent_id',
        'address',
        'phone',
        'email',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the parent branch.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'parent_id');
    }

    /**
     * Get child branches.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Branch::class, 'parent_id');
    }

    /**
     * Get departments in this branch.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all assignments to this branch.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get active assignments.
     */
    public function activeAssignments(): HasMany
    {
        return $this->assignments()->where('status', 'active');
    }

    /**
     * Get active employees in this branch.
     */
    public function employees()
    {
        return $this->hasManyThrough(
            Employee::class,
            Assignment::class,
            'branch_id',
            'id',
            'id',
            'employee_id'
        )->where('assignments.status', 'active');
    }
}
