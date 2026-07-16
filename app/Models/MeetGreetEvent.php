<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetGreetEvent extends Model
{
    protected $fillable = [
        'celebrity_id', 'title', 'description', 'date', 'location', 'capacity', 'price', 'image_url', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function tickets()
    {
        return $this->hasMany(MeetGreetTicket::class, 'event_id');
    }
}
