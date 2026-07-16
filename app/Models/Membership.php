<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'celebrity_id', 'user_id', 'tier', 'price', 'start_date', 'end_date', 'is_active',
        'auto_renew', 'payment_method', 'payment_ref', 'payment_proof', 'stripe_sub_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_active' => 'boolean',
            'auto_renew' => 'boolean',
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
