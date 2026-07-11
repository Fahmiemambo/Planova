<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'type', 'config', 'position',
    ];

    protected $casts = [
        'config'   => 'array',
        'position' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(TaskPropertyValue::class, 'property_id');
    }

    // ── Helpers ────────────────────────────────────────────

    /**
     * Returns the list of select options from config, or empty array.
     */
    public function getOptionsAttribute(): array
    {
        return $this->config['options'] ?? [];
    }

    /**
     * Find a single option by its id.
     */
    public function findOption(string $optionId): ?array
    {
        foreach ($this->options as $opt) {
            if (($opt['id'] ?? '') === $optionId) {
                return $opt;
            }
        }
        return null;
    }

    /**
     * Icon for each property type.
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'select'   => 'bi-list-check',
            'text'     => 'bi-fonts',
            'date'     => 'bi-calendar3',
            'checkbox' => 'bi-check2-square',
            'number'   => 'bi-hash',
            'url'      => 'bi-link-45deg',
            default    => 'bi-tag',
        };
    }
}
