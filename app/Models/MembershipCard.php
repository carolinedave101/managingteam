<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipCard extends Model
{
    protected $fillable = [
        'celebrity_id', 'user_id', 'card_number', 'tier', 'price', 'issued_at', 'expires_at', 'is_active',
        'payment_method', 'payment_ref', 'payment_proof', 'stripe_payment_id',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
