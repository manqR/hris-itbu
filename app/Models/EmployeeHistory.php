<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * EmployeeHistory Model
 * 
 * Tracks all historical changes to employee records for audit purposes.
 */
class EmployeeHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'change_type',
        'field_name',
        'old_value',
        'new_value',
        'effective_date',
        'notes',
        'changed_by',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Boot method.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
        });
    }

    /**
     * Get the employee.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who made the change.
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Get formatted change type label.
     */
    public function getChangeTypeLabelAttribute(): string
    {
        return match($this->change_type) {
            'profile_update' => 'Profile Updated',
            'status_change' => 'Status Changed',
            'assignment_added' => 'Assignment Added',
            'assignment_updated' => 'Assignment Updated',
            'assignment_ended' => 'Assignment Ended',
            'position_change' => 'Position Changed',
            'supervisor_change' => 'Supervisor Changed',
            'termination' => 'Employment Terminated',
            'reinstatement' => 'Reinstated',
            default => ucfirst(str_replace('_', ' ', $this->change_type)),
        };
    }

    /**
     * Scope by change type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('change_type', $type);
    }

    /**
     * Scope by date range.
     */
    public function scopeBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('effective_date', [$startDate, $endDate]);
    }
}
