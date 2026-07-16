<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'celebrity_id', 'user_id', 'amount', 'currency', 'status', 'stripe_payment_id',
        'payment_method', 'payment_ref', 'description', 'metadata',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'metadata' => 'array',
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
