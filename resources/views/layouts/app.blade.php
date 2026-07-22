<!DOCTYPE html>
@php $celebrity = $celebrity ?? null; @endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="unread-messages" content="{{ auth()->check() ? auth()->user()->receivedMessages()->where('is_read', false)->count() : 0 }}">
        @php
            $navWallet = 0;
            if (auth()->check() && isset($celebrity) && $celebrity) {
                $navWallet = auth()->user()->wallets()->where('celebrity_id', $celebrity->id)->value('balance') ?? 0;
            }
        @endphp
        <meta name="wallet-balance" content="{{ $navWallet }}">
        <link rel="icon" href="{{ $celebrity ? $celebrity->getFaviconUrl() : '/favicon.svg' }}" type="image/svg+xml">
        <link rel="icon" href="{{ $celebrity ? $celebrity->getFaviconUrl() : '/favicon.ico' }}" sizes="any">
        <link rel="apple-touch-icon" href="{{ $celebrity ? $celebrity->getAvatarUrl() : '/favicon.ico' }}">
        @if(!$celebrity)<link rel="manifest" href="/site.webmanifest">@endif

        <title>{{ $celebrity ? $celebrity->name . ' — Official Fan Community' : config('app.name', 'JennieKim') . ' — Official Fan Community' }}</title>
        <meta name="description" content="{{ $celebrity ? 'Join the official ' . $celebrity->name . ' fan community.' : 'Join the official Jennie Kim fan community. Exclusive memberships, meet & greet events, and unforgettable fan moments.' }}">

        @if ($celebrity)
            @php
                $t = $celebrity->config['theme'] ?? [];
                $primary = $t['primary_color'] ?? '#ec4899';
                $secondary = $t['secondary_color'] ?? '#8b5cf6';
                $fonts = $t['fonts'] ?? ['heading' => 'Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500', 'body' => 'Manrope:wght@400;500;600;700;800'];
                $headingFont = explode(':', $fonts['heading'])[0] ?? 'Playfair+Display';
                $bgType = $t['background_type'] ?? 'mesh';
                $bgColor = $t['background_color'] ?? '#ffffff';
                $bgImage = $t['background_image_url'] ?? '';
            @endphp
            <style>
                :root {
                    --accent: <?= $primary ?>;
                    --accent-deep: <?= $primary ?>;
                    --accent-light: <?= $primary ?>15;
                    --accent-soft-bg: <?= $primary ?>14;
                    --accent-secondary: <?= $secondary ?>;
                    --accent-glow: <?= $primary ?>4D;
                    --accent-glow-strong: <?= $primary ?>80;
                    --font-heading: '<?= str_replace('+', ' ', $headingFont) ?>', ui-serif, Georgia, serif;
                    --page-bg-type: <?= $bgType ?>;
                    --page-bg-color: <?= $bgColor ?>;
                    --page-bg-image: <?= $bgImage ? "url({$bgImage})" : 'none' ?>;
                }
                body.page-bg-solid .mesh-gradient,
                body.page-bg-solid .mesh-gradient-deep,
                body.page-bg-solid .page-bg-gradient {
                    background: <?= $bgColor ?> !important;
                }
                body.page-bg-image .mesh-gradient,
                body.page-bg-image .mesh-gradient-deep,
                body.page-bg-image .page-bg-gradient {
                    background-image: <?= $bgImage ? "url({$bgImage})" : 'none' ?> !important;
                    background-size: cover !important;
                    background-position: center !important;
                    background-attachment: fixed !important;
                }
            </style>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family={{ $fonts['heading'] }}&family={{ $fonts['body'] }}&display=swap" rel="stylesheet">
        @else
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        @endif
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-gray-900 page-bg-{{ $bgType ?? 'mesh' }}" style="background-color: {{ $bgColor ?? '#ffffff' }};" data-category="{{ $celebrity?->category ?? 'general' }}">
        <div class="min-h-screen flex flex-col">
            <livewire:navigation />

            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                     class="container-x mt-4">
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2" role="alert">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                     class="container-x mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2" role="alert">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <main class="flex-1">
                {{ $slot }}
            </main>

            <x-footer />
        </div>

        <div x-data x-cloak class="fixed bottom-4 right-4 z-50 flex flex-col gap-2">
            <template x-for="toast in $store.notifications.toasts" :key="toast.id">
                <div x-show="true" x-transition.duration.300ms
                     :class="{
                         'bg-green-600': toast.type === 'success',
                         'bg-red-600': toast.type === 'error',
                         'bg-blue-600': toast.type === 'info',
                         'bg-yellow-500': toast.type === 'warning',
                         'bg-gray-800': !['success','error','info','warning'].includes(toast.type)
                     }"
                     class="text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 min-w-[280px] max-w-sm text-sm font-medium cursor-pointer"
                     @click="$store.notifications.removeToast(toast.id)">
                    <svg x-show="toast.type === 'success'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <svg x-show="toast.type === 'error'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <svg x-show="toast.type === 'info'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-text="toast.message"></span>
                </div>
            </template>
        </div>
        @filamentScripts
        @livewireScripts

        @auth
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                @php
                    $user = auth()->user();
                    $celeb = $celebrity ?? $user->celebrities()->first();
                @endphp
                @if ($celeb)
                const celebId = {{ $celeb->id }};
                const userId = {{ $user->id }};
                if (window.Echo) {
                    const channel = window.Echo.private(`celebrity.${celebId}.fan.${userId}`);

                    channel.listen('.message.sent', (e) => {
                        const store = Alpine.store('notifications');
                        store.incrementMessages();
                        store.addToast('📩 ' + e.from + ': ' + e.subject, 'info');
                        window.dispatchEvent(new CustomEvent('$refresh'));
                    });

                    channel.listen('.membership.updated', (e) => {
                        const store = Alpine.store('notifications');
                        store.addToast(
                            'Membership ' + (e.status === 'active' ? 'upgraded' : 'cancelled') + ' to ' + e.tier,
                            e.status === 'active' ? 'success' : 'warning'
                        );
                    });

                    channel.listen('.application.reviewed', (e) => {
                        Alpine.store('notifications').addToast(
                            'Your application was ' + e.status,
                            e.status === 'approved' ? 'success' : 'error'
                        );
                    });

                    channel.listen('.application.submitted', (e) => {
                        Alpine.store('notifications').addToast(
                            'Application submitted — awaiting review.',
                            'info'
                        );
                    });

                    channel.listen('.wallet.updated', (e) => {
                        Alpine.store('wallet').setBalance(e.balance);
                        Alpine.store('notifications').addToast(
                            (e.type === 'credit' ? '+' : '-') + '$' + parseFloat(e.amount).toFixed(2) + ' wallet ' + (e.type === 'credit' ? 'deposited' : 'spent'),
                            e.type === 'credit' ? 'success' : 'info'
                        );
                    });

                    channel.listen('.meetgreet.booked', (e) => {
                        Alpine.store('notifications').addToast(
                            'Tickets booked for ' + e.event + ' (×' + e.quantity + ')',
                            'success'
                        );
                    });

                    channel.listen('.card.ordered', (e) => {
                        Alpine.store('notifications').addToast(
                            'Membership card ordered: ' + e.card_number,
                            'success'
                        );
                    });

                    channel.listen('.private.meetup.booked', (e) => {
                        Alpine.store('notifications').addToast(
                            'Meetup "' + e.title + '" booked — ' + e.status,
                            'success'
                        );
                    });
                }
                @endif

                // Admin notification channel (global)
                @if ($user->isAdmin())
                if (window.Echo) {
                    window.Echo.private('admin.global')
                        .listen('.admin.notification', (e) => {
                            Alpine.store('notifications').addToast(
                                '🔔 ' + e.message,
                                'info'
                            );
                        });
                }
                @endif
            });
        </script>
        @endauth

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const els = document.querySelectorAll('.reveal');
                if (!('IntersectionObserver' in window) || !els.length) {
                    els.forEach(el => el.classList.add('is-visible'));
                    return;
                }
                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });
                els.forEach(el => io.observe(el));
            });
        </script>
    </body>
</html>
