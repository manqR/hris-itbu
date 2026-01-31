<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\BaseModel;

class Attendance extends Model
{
    use BaseModel;

    protected $fillable = [
        'assignment_id',
        'date',
        'clock_in_time',
        'clock_out_time',
        'status',
        'latitude_in',
        'longitude_in',
        'latitude_out',
        'longitude_out',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in_time' => 'datetime:H:i:s',
        'clock_out_time' => 'datetime:H:i:s',
        'latitude_in' => 'decimal:8',
        'longitude_in' => 'decimal:8',
        'latitude_out' => 'decimal:8',
        'longitude_out' => 'decimal:8',
    ];

    // Relationships
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}
