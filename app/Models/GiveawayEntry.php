<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiveawayEntry extends Model
{
    protected $fillable = [
        'giveaway_id', 'user_id', 'celebrity_id', 'entry_number', 'status',
        'prize_credited', 'payment_method', 'payment_proof', 'heartfelt_note',
        'stripe_payment_id', 'claimed_at',
    ];

    protected function casts(): array
    {
        return [
            'prize_credited' => 'boolean',
            'claimed_at' => 'datetime',
            'entry_number' => 'integer',
        ];
    }

    public function giveaway()
    {
        return $this->belongsTo(Giveaway::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function scopeForCelebrity($query, $celebrityId)
    {
        return $query->where('celebrity_id', $celebrityId);
    }
}
