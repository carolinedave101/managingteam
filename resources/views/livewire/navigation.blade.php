<nav x-data="{ mobileOpen: false }" class="sticky top-0 z-40 glass"
     wire:poll.10s="loadUnreadCount; loadWalletBalance">
    <div class="container-x">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-10">
                <a href="{{ $celebrity ? url('/') : '/' }}" class="flex items-center gap-2 group">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-white font-display font-bold shadow-glow accent-bg">
                        {{ $celebrity ? strtoupper(substr($celebrity->name, 0, 1)) : 'J' }}
                    </span>
                    <span class="text-xl font-display font-bold text-gray-900">
                        @if ($celebrity)
                            {{ $celebrity->name }}
                        @else
                            Jennie<span class="accent-text">Kim</span>
                        @endif
                    </span>
                </a>
                @if ($celebrity)
                <div class="hidden md:flex items-center gap-1">
                    <x-nav-link href="{{ route('celebrity.home', ['celebrity' => $celebrity->slug]) }}" :active="request()->routeIs('celebrity.home')">Home</x-nav-link>
                    @if ($celebrity->config['features']['fan_applications'] ?? false)
                        <x-nav-link href="{{ route('celebrity.apply', ['celebrity' => $celebrity->slug]) }}" :active="request()->routeIs('celebrity.apply')">Apply</x-nav-link>
                    @endif
                    @if ($celebrity->config['features']['membership'] ?? false)
                        <x-nav-link href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" :active="request()->routeIs('celebrity.membership')">Membership</x-nav-link>
                    @endif
                    @if ($celebrity->config['features']['meet_greet'] ?? false)
                        <x-nav-link href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}" :active="request()->routeIs('celebrity.meet-greet')">Meet &amp; Greet</x-nav-link>
                    @endif
                    @if ($celebrity->config['features']['membership_card'] ?? false)
                        <x-nav-link href="{{ route('celebrity.membership-card', ['celebrity' => $celebrity->slug]) }}" :active="request()->routeIs('celebrity.membership-card')">Card</x-nav-link>
                    @endif
                    @if ($celebrity->config['features']['private_meetup'] ?? false)
                        <x-nav-link href="{{ route('celebrity.private-meetup', ['celebrity' => $celebrity->slug]) }}" :active="request()->routeIs('celebrity.private-meetup')">Private Meetup</x-nav-link>
                    @endif
                    @auth
                        <x-nav-link href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" :active="request()->routeIs('celebrity.dashboard')">
                            Dashboard
                            @if ($unreadMessages > 0)
                                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ min($unreadMessages, 99) }}</span>
                            @endif
                        </x-nav-link>
                    @endauth
                </div>
                @endif
            </div>
            <div class="flex items-center gap-2">
                @auth
                    @if ($celebrity)
                        <a href="{{ route('celebrity.messages', ['celebrity' => $celebrity->slug]) }}"
                           class="relative p-2 text-gray-500 hover:text-gray-900 transition rounded-lg hover:bg-gray-100"
                           title="Messages">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span x-show="$store.notifications.unreadMessages > 0"
                                  x-cloak
                                  x-text="$store.notifications.unreadMessages > 99 ? '99+' : $store.notifications.unreadMessages"
                                  class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-red-500 rounded-full leading-none">
                            </span>
                        </a>

                        <a href="{{ route('celebrity.wallet', ['celebrity' => $celebrity->slug]) }}"
                           class="flex items-center gap-1.5 px-3 py-1.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition"
                           title="Wallet Balance">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span data-wallet-balance x-text="'$' + parseFloat($store.wallet.balance).toFixed(2)">${{ number_format($walletBalance, 2) }}</span>
                        </a>

                        <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="flex items-center gap-2 group">
                            <x-user-avatar :user="auth()->user()" size="md" />
                            <span class="hidden md:inline text-sm font-medium text-gray-700 group-hover:accent-text transition">{{ auth()->user()->name }}</span>
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-900 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:accent-text transition">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary !py-2 !px-5">Join</a>
                @endauth
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-gray-700" aria-label="Menu">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>
    @if ($celebrity)
    <div x-show="mobileOpen" x-transition x-cloak class="md:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            <x-responsive-nav-link href="{{ route('celebrity.home', ['celebrity' => $celebrity->slug]) }}">Home</x-responsive-nav-link>
            @if ($celebrity->config['features']['fan_applications'] ?? false)
                <x-responsive-nav-link href="{{ route('celebrity.apply', ['celebrity' => $celebrity->slug]) }}">Apply</x-responsive-nav-link>
            @endif
            @if ($celebrity->config['features']['membership'] ?? false)
                <x-responsive-nav-link href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}">Membership</x-responsive-nav-link>
            @endif
            @if ($celebrity->config['features']['meet_greet'] ?? false)
                <x-responsive-nav-link href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}">Meet &amp; Greet</x-responsive-nav-link>
            @endif
            @if ($celebrity->config['features']['membership_card'] ?? false)
                <x-responsive-nav-link href="{{ route('celebrity.membership-card', ['celebrity' => $celebrity->slug]) }}">Card</x-responsive-nav-link>
            @endif
            @if ($celebrity->config['features']['private_meetup'] ?? false)
                <x-responsive-nav-link href="{{ route('celebrity.private-meetup', ['celebrity' => $celebrity->slug]) }}">Private Meetup</x-responsive-nav-link>
            @endif
            @auth
                <x-responsive-nav-link href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}">
                    Dashboard
                    @if ($unreadMessages > 0)
                        <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ min($unreadMessages, 99) }}</span>
                    @endif
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('celebrity.messages', ['celebrity' => $celebrity->slug]) }}">
                    Messages
                    <span x-show="$store.notifications.unreadMessages > 0"
                          x-cloak
                          x-text="'(' + $store.notifications.unreadMessages + ')'"
                          class="ml-1 text-xs text-red-500">
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('celebrity.wallet', ['celebrity' => $celebrity->slug]) }}">
                    Wallet
                    <span class="ml-1 text-xs text-gray-500" data-wallet-balance x-text="'($' + parseFloat($store.wallet.balance).toFixed(2) + ')'">(${{ number_format($walletBalance, 2) }})</span>
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-sm text-red-600">Logout</button>
                </form>
            @else
                <x-responsive-nav-link href="{{ route('login') }}">Login</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('register') }}">Join</x-responsive-nav-link>
            @endauth
        </div>
    </div>
    @endif
</nav>