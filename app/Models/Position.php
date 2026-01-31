<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Position Model
 * 
 * Job titles/positions that employees can hold
 */
class Position extends Model
{
    use BaseModel;

    protected $fillable = [
        'code',
        'name',
        'level',
        'description',
        'responsibilities',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
    ];

    /**
     * Position level constants
     */
    const LEVEL_STAFF = 1;
    const LEVEL_SENIOR_STAFF = 2;
    const LEVEL_SUPERVISOR = 3;
    const LEVEL_MANAGER = 4;
    const LEVEL_SENIOR_MANAGER = 5;
    const LEVEL_DIRECTOR = 6;
    const LEVEL_EXECUTIVE = 7;

    /**
     * Get level label.
     */
    public function getLevelLabelAttribute(): string
    {
        return match($this->level) {
            self::LEVEL_STAFF => 'Staff',
            self::LEVEL_SENIOR_STAFF => 'Senior Staff',
            self::LEVEL_SUPERVISOR => 'Supervisor',
            self::LEVEL_MANAGER => 'Manager',
            self::LEVEL_SENIOR_MANAGER => 'Senior Manager',
            self::LEVEL_DIRECTOR => 'Director',
            self::LEVEL_EXECUTIVE => 'Executive',
            default => 'Unknown',
        };
    }

    /**
     * Get assignments with this position.
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
}
