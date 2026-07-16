<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FanApplication extends Model
{
    protected $fillable = [
        'celebrity_id', 'user_id', 'bio', 'reason', 'social_links', 'status', 'price',
        'payment_method', 'payment_proof', 'reviewed_by', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
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
