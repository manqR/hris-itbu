<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveBalance extends Model
{
    protected $fillable = [
        'assignment_id',
        'leave_type_id',
        'year',
        'quota',
        'used',
        'remaining',
    ];

    protected $casts = [
        'quota' => 'decimal:2',
        'used' => 'decimal:2',
        'remaining' => 'decimal:2',
    ];

    // Relationships
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }
}
