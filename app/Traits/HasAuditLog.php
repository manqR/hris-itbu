<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Adds automatic audit logging to models.
 * 
 * Usage: Add `use HasAuditLog;` to your model.
 * This will automatically log all create, update, and delete actions.
 */
trait HasAuditLog
{
    /**
     * Boot the trait on model.
     */
    public static function bootHasAuditLog(): void
    {
        static::created(function (Model $model) {
            $model->logAudit('created', null, $model->getAttributes());
        });

        static::updated(function (Model $model) {
            $original = $model->getOriginal();
            $changes = $model->getChanges();
            
            // Remove timestamps from changes
            unset($changes['updated_at']);
            
            if (!empty($changes)) {
                $model->logAudit('updated', $original, $changes);
            }
        });

        static::deleted(function (Model $model) {
            $model->logAudit('deleted', $model->getOriginal(), null);
        });
    }

    /**
     * Log an audit entry.
     */
    protected function logAudit(string $action, ?array $oldValues, ?array $newValues): void
    {
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->getKey(),
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get audit logs for this model.
     */
    public function auditLogs()
    {
        return $this->morphMany(\App\Models\AuditLog::class, 'auditable');
    }
}
