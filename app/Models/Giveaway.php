<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Giveaway extends Model
{
    protected $fillable = [
        'celebrity_id', 'fan_id', 'title', 'description', 'prize_description', 'prize_amount',
        'prize_image_url', 'entry_fee', 'winner_count', 'max_entries_per_fan',
        'starts_at', 'ends_at', 'status', 'is_active', 'config',
    ];

    protected function casts(): array
    {
        return [
            'prize_amount' => 'decimal:2',
            'entry_fee' => 'decimal:2',
            'winner_count' => 'integer',
            'max_entries_per_fan' => 'integer',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
            'config' => 'array',
        ];
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function fan()
    {
        return $this->belongsTo(User::class, 'fan_id');
    }

    public function entries()
    {
        return $this->hasMany(GiveawayEntry::class);
    }

    public function winners()
    {
        return $this->hasMany(GiveawayEntry::class)->where('status', 'won');
    }

    public function isActive(): bool
    {
        return $this->is_active
            && $this->status === 'active'
            && (!$this->starts_at || $this->starts_at->isPast())
            && (!$this->ends_at || $this->ends_at->isFuture());
    }

    public function isEnded(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    public function isFree(): bool
    {
        return $this->entry_fee == 0;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            });
    }

    public function scopeForCelebrity($query, $celebrityId)
    {
        return $query->where('celebrity_id', $celebrityId);
    }

    public function scopeAccessibleBy($query, ?int $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->whereNull('fan_id');
            if ($userId) {
                $q->orWhere('fan_id', $userId);
            }
        });
    }

    public function getEntryCount(): int
    {
        return $this->entries()->count();
    }

    public function getEntryCountForUser(int $userId): int
    {
        return $this->entries()->where('user_id', $userId)->count();
    }
}
