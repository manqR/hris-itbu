<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [
        'code',
        'name',
        'days_allocated',
        'requires_file',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_file' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
