<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    protected $fillable = [
        'celebrity_id',
        'subject',
        'body',
        'status',
        'total_recipients',
        'sent_count',
        'failed_count',
        'hourly_limit',
        'hourly_sent_count',
        'hourly_sent_reset_at',
        'daily_limit',
        'daily_sent_count',
        'daily_sent_reset_at',
        'subject_variations',
        'body_variations',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'hourly_sent_reset_at' => 'datetime',
            'daily_sent_reset_at' => 'datetime',
            'subject_variations' => 'array',
            'body_variations' => 'array',
        ];
    }

    public function celebrity(): BelongsTo
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'campaign_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSending($query)
    {
        return $query->where('status', 'sending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function isWithinHourlyLimit(): bool
    {
        $this->resetHourlyCountIfNeeded();

        return $this->hourly_sent_count < $this->hourly_limit;
    }

    public function isWithinDailyLimit(): bool
    {
        $this->resetDailyCountIfNeeded();

        return $this->daily_sent_count < $this->daily_limit;
    }

    public function canSend(): bool
    {
        return $this->status === 'sending'
            && $this->isWithinHourlyLimit()
            && $this->isWithinDailyLimit();
    }

    public function remainingHourly(): int
    {
        $this->resetHourlyCountIfNeeded();

        return max(0, $this->hourly_limit - $this->hourly_sent_count);
    }

    public function remainingDaily(): int
    {
        $this->resetDailyCountIfNeeded();

        return max(0, $this->daily_limit - $this->daily_sent_count);
    }

    public function resetHourlyCountIfNeeded(): void
    {
        if ($this->hourly_sent_reset_at === null || $this->hourly_sent_reset_at->copy()->addHour()->isPast()) {
            $this->hourly_sent_count = 0;
            $this->hourly_sent_reset_at = now();
        }
    }

    public function resetDailyCountIfNeeded(): void
    {
        if ($this->daily_sent_reset_at === null || $this->daily_sent_reset_at->copy()->addDay()->isPast()) {
            $this->daily_sent_count = 0;
            $this->daily_sent_reset_at = now();
        }
    }

    public function progressPercent(): float
    {
        if ($this->total_recipients === 0) {
            return 0;
        }

        return round(($this->sent_count + $this->failed_count) / $this->total_recipients * 100, 1);
    }

    public function markBatchProgress(int $sent, int $failed): void
    {
        $this->increment('sent_count', $sent);
        $this->increment('failed_count', $failed);

        $this->hourly_sent_count += $sent;
        $this->daily_sent_count += $sent;

        $this->saveQuietly();

        $fresh = $this->fresh();
        if ($fresh->sent_count + $fresh->failed_count >= $this->total_recipients) {
            $this->status = 'completed';
            $this->saveQuietly();
        }
    }
}
