<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Employee Model
 * 
 * Core employee data with multi-assignment support
 */
class Employee extends Model
{
    use BaseModel;

    protected $fillable = [
        'employee_number',
        'name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'birth_place',
        'address',
        'id_number',
        'tax_number',
        'bank_account',
        'bank_name',
        'hire_date',
        'termination_date',
        'employment_status',
        'employment_type',
        'photo',
        'user_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'termination_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user account linked to this employee.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all assignments for this employee.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get active assignments only.
     */
    public function activeAssignments(): HasMany
    {
        return $this->hasMany(Assignment::class)->where('status', 'active');
    }

    /**
     * Get the primary assignment.
     */
    public function primaryAssignment()
    {
        return $this->hasOne(Assignment::class)
            ->where('is_primary', true)
            ->where('status', 'active');
    }

    /**
     * Get employment history.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(EmployeeHistory::class)->orderByDesc('created_at');
    }

    /**
     * Get employees supervised by this employee.
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(Assignment::class, 'supervisor_id')
            ->where('status', 'active');
    }

    /**
     * Get full name with employee number.
     */
    public function getFullIdentifierAttribute(): string
    {
        return "{$this->employee_number} - {$this->name}";
    }

    /**
     * Get years of service.
     */
    public function getYearsOfServiceAttribute(): float
    {
        $endDate = $this->termination_date ?? now();
        return round($this->hire_date->diffInYears($endDate), 1);
    }

    /**
     * Check if employee is assigned to a specific branch.
     */
    public function isAssignedTo(int $branchId): bool
    {
        return $this->activeAssignments()
            ->where('branch_id', $branchId)
            ->exists();
    }

    /**
     * Record history entry.
     */
    public function recordHistory(
        string $changeType,
        ?string $fieldName = null,
        mixed $oldValue = null,
        mixed $newValue = null,
        ?\DateTime $effectiveDate = null,
        ?string $notes = null
    ): EmployeeHistory {
        return $this->histories()->create([
            'change_type' => $changeType,
            'field_name' => $fieldName,
            'old_value' => is_array($oldValue) ? json_encode($oldValue) : $oldValue,
            'new_value' => is_array($newValue) ? json_encode($newValue) : $newValue,
            'effective_date' => $effectiveDate ?? now(),
            'notes' => $notes,
            'changed_by' => auth()->id(),
        ]);
    }
}
