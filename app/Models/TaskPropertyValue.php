<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskPropertyValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id', 'property_id', 'value',
    ];

    // ── Relationships ──────────────────────────────────────

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(TaskProperty::class, 'property_id');
    }

    // ── Helpers ────────────────────────────────────────────

    /**
     * For 'select' type: resolve the full option array from the property config.
     */
    public function getResolvedOptionAttribute(): ?array
    {
        if (!$this->property || $this->property->type !== 'select') {
            return null;
        }
        return $this->property->findOption($this->value ?? '');
    }
}
