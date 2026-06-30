<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'limit_amount', 'period',
        'period_year', 'period_month',
    ];

    protected $casts = [
        'limit_amount' => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // ── Computed: spent amount for this period ─────────────

    public function getSpentAmountAttribute(): float
    {
        $query = FinanceRecord::where('user_id', $this->user_id)
            ->where('type', 'expense');

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->period === 'monthly' && $this->period_year && $this->period_month) {
            $query->whereYear('date', $this->period_year)
                  ->whereMonth('date', $this->period_month);
        } elseif ($this->period === 'yearly' && $this->period_year) {
            $query->whereYear('date', $this->period_year);
        }

        return (float) $query->sum('amount');
    }

    public function getUsagePercentAttribute(): float
    {
        if ($this->limit_amount <= 0) return 0;
        return min(100, round(($this->spent_amount / $this->limit_amount) * 100, 1));
    }

    public function getRemainingAttribute(): float
    {
        return max(0, $this->limit_amount - $this->spent_amount);
    }

    public function getFormattedLimitAttribute(): string
    {
        return 'Rp ' . number_format($this->limit_amount, 0, ',', '.');
    }

    public function getFormattedSpentAttribute(): string
    {
        return 'Rp ' . number_format($this->spent_amount, 0, ',', '.');
    }
}
