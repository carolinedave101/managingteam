<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelebrityPaymentMethod extends Model
{
    protected $fillable = [
        'celebrity_id', 'type', 'label', 'enabled', 'details', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'details' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
