<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMeetup extends Model
{
    protected $fillable = [
        'celebrity_id', 'user_id', 'title', 'description', 'date', 'duration', 'location', 'price',
        'status', 'notes', 'payment_method', 'payment_ref', 'payment_proof', 'rejection_reason', 'stripe_payment_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'price' => 'decimal:2',
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
