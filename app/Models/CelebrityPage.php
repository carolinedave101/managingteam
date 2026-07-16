<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelebrityPage extends Model
{
    protected $fillable = [
        'celebrity_id', 'title', 'slug', 'content', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }
}
