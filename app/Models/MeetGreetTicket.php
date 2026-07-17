<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetGreetTicket extends Model
{
    protected $fillable = [
        'celebrity_id', 'user_id', 'event_id', 'quantity', 'total_price', 'status',
        'payment_method', 'payment_ref', 'payment_proof', 'rejection_reason', 'stripe_payment_id',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
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

    public function event()
    {
        return $this->belongsTo(MeetGreetEvent::class, 'event_id');
    }
}
