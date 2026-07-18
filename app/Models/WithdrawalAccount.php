<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalAccount extends Model
{
    protected $fillable = [
        'user_id', 'celebrity_id', 'type', 'label', 'details', 'is_default',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'is_default' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }
}
