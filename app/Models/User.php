<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'role', 'is_verified',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    public function application()
    {
        return $this->hasOne(FanApplication::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function celebrities()
    {
        return $this->belongsToMany(Celebrity::class, 'celebrity_fan')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function managedCelebrities()
    {
        return $this->hasMany(Celebrity::class, 'created_by');
    }

    public function redirectLinks()
    {
        return $this->hasMany(RedirectLink::class, 'created_by');
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function walletForCelebrity(Celebrity $celebrity): ?Wallet
    {
        return $this->wallets()->where('celebrity_id', $celebrity->id)->first();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isFan(): bool
    {
        return $this->role === 'fan';
    }

    public function avatarUrl(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }
}
