<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'blockable_id', 'blockable_type', 'type', 'content', 'order',
    ];

    protected $casts = [
        'content' => 'array',
        'order'   => 'integer',
    ];

    // ── Polymorphic ────────────────────────────────────────

    public function blockable(): MorphTo
    {
        return $this->morphTo();
    }

    // ── Helpers ────────────────────────────────────────────

    /**
     * Get plain text representation of block content.
     */
    public function getTextAttribute(): string
    {
        $content = $this->content ?? [];
        return match($this->type) {
            'text', 'heading', 'bullet_list' => $content['text'] ?? '',
            'todo'                            => $content['text'] ?? '',
            'divider'                         => '---',
            'table'                           => '[Table]',
            default                           => '',
        };
    }
}
