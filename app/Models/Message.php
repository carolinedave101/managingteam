<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'celebrity_id', 'sender_id', 'receiver_id', 'parent_id',
        'reference_type', 'reference_id',
        'subject', 'content', 'is_read', 'payment_complete',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'payment_complete' => 'boolean',
        ];
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }
}
