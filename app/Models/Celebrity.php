<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Celebrity extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'name', 'slug', 'avatar', 'cover_photo', 'bio', 'category',
        'gender', 'country',
        'social_links', 'config', 'is_active', 'created_by',
    ];

    public static array $categories = [
        'general' => 'General',
        'movie_star' => 'Movie Star',
        'country_singer' => 'Country Singer',
        'musician' => 'Musician',
        'adult_star' => 'Adult Star',
    ];

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getAvatarUrl(): string
    {
        if ($this->avatar) {
            return $this->avatar;
        }
        return static::avatarUrlFor($this->name);
    }

    public function getCoverUrl(): string
    {
        if ($this->cover_photo) {
            return $this->cover_photo;
        }
        return static::coverUrlFor($this->slug);
    }

    public function categoryLabel(): string
    {
        return static::$categories[$this->category] ?? 'General';
    }

    public static function avatarUrlFor(string $name): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&size=400&background=random&color=fff&bold=true';
    }

    public static function coverUrlFor(string $slug): string
    {
        return 'https://picsum.photos/seed/'.$slug.'/1200/600';
    }

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'config' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fans()
    {
        return $this->belongsToMany(User::class, 'celebrity_fan')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'celebrity_admin')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function pages()
    {
        return $this->hasMany(CelebrityPage::class);
    }

    public function redirectLinks()
    {
        return $this->hasMany(RedirectLink::class);
    }

    public function fanApplications()
    {
        return $this->hasMany(FanApplication::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function meetGreetEvents()
    {
        return $this->hasMany(MeetGreetEvent::class);
    }

    public function meetGreetTickets()
    {
        return $this->hasMany(MeetGreetTicket::class);
    }

    public function membershipCards()
    {
        return $this->hasMany(MembershipCard::class);
    }

    public function privateMeetups()
    {
        return $this->hasMany(PrivateMeetup::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(CelebrityPaymentMethod::class)->ordered();
    }

    public function enabledPaymentMethods()
    {
        return $this->hasMany(CelebrityPaymentMethod::class)->enabled()->ordered();
    }

    public function getPortalUrl(): string
    {
        $appUrl = config('app.url');
        $scheme = parse_url($appUrl, PHP_URL_SCHEME) ?: 'https';
        $host = parse_url($appUrl, PHP_URL_HOST);
        $port = parse_url($appUrl, PHP_URL_PORT);
        $base = $port ? "{$host}:{$port}" : $host;

        return "{$scheme}://{$this->slug}.{$base}";
    }
}
