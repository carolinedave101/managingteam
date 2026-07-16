<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RedirectLink extends Model
{
    protected $fillable = [
        'celebrity_id', 'code', 'target_url', 'clicks', 'is_active', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'clicks' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getShortUrl(): string
    {
        return url('/r/'.$this->code);
    }

    public static function generateUniqueCode(int $length = 6): string
    {
        do {
            $code = Str::random($length);
        } while (static::where('code', $code)->exists());

        return $code;
    }

    public function incrementClicks(): void
    {
        $this->increment('clicks');
    }
}
