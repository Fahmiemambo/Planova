<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'status', 'due_date', 'priority',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // ── Relationships ──────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blocks(): MorphMany
    {
        return $this->morphMany(Block::class, 'blockable')->orderBy('order');
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    // ── Helpers ────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'todo'        => 'Todo',
            'in_progress' => 'In Progress',
            'done'        => 'Done',
            default       => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'todo'        => 'badge-todo',
            'in_progress' => 'badge-progress',
            'done'        => 'badge-done',
            default       => 'badge-todo',
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'done';
    }
}
