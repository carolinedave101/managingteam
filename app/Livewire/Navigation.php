<?php

namespace App\Livewire;

use App\Models\Celebrity;
use Livewire\Component;

class Navigation extends Component
{
    public bool $isMobileMenuOpen = false;

    public ?Celebrity $celebrity = null;

    public int $unreadMessages = 0;

    public float $walletBalance = 0;

    protected $listeners = ['$refresh'];

    public function mount(): void
    {
        $this->resolveCelebrity();
        $this->loadUnreadCount();
        $this->loadWalletBalance();
    }

    public function loadUnreadCount(): void
    {
        if ($user = auth()->user()) {
            $this->unreadMessages = $user->receivedMessages()->where('is_read', false)->count();
        }
    }

    public function loadWalletBalance(): void
    {
        if (! $user = auth()->user()) {
            $this->walletBalance = 0;
            return;
        }
        if (! $this->celebrity) {
            $this->walletBalance = 0;
            return;
        }
        $wallet = $user->wallets()->where('celebrity_id', $this->celebrity->id)->first();
        $this->walletBalance = $wallet?->balance ?? 0;
    }

    public function toggleMobileMenu(): void
    {
        $this->isMobileMenuOpen = ! $this->isMobileMenuOpen;
    }

    public function render()
    {
        return view('livewire.navigation');
    }

    private function resolveCelebrity(): void
    {
        $route = request()->route();
        if ($route && $route->hasParameter('celebrity')) {
            $param = $route->parameter('celebrity');
            if ($param instanceof Celebrity) {
                $this->celebrity = $param;
            } elseif (is_string($param)) {
                $this->celebrity = Celebrity::where('slug', $param)->first();
            }
        }
        if (! $this->celebrity && view()->getShared() && array_key_exists('celebrity', view()->getShared())) {
            $shared = view()->shared('celebrity');
            if ($shared instanceof Celebrity) {
                $this->celebrity = $shared;
            }
        }
    }
}
