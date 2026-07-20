@php
    $c = $celebrity->config;
    $content = $c['site_content'] ?? [];
    $features = $c['features'] ?? [];
    $tiers = $c['membership_tiers'] ?? [];
    $cat = $celebrity->category;

    $catHeroDefaults = [
        'movie_star' => [
            'badge' => 'Official Fan Community',
            'title' => '<span style="color: #fbbf24;">Hollywood</span> Awaits You',
            'subtitle' => 'Get exclusive red carpet access, behind-the-scenes content, and VIP meet & greets with your favorite star.',
        ],
        'country_singer' => [
            'badge' => 'Official Fan Community',
            'title' => '<span style="color: #f59e0b;">Front Row</span> Access Awaits',
            'subtitle' => 'Join the family. Get backstage passes, exclusive acoustic sessions, and VIP concert access.',
        ],
        'adult_star' => [
            'badge' => 'Exclusive Fan Community',
            'title' => '<span style="color: #ec4899;">Premium</span> Access Awaits',
            'subtitle' => 'Unlock exclusive content, private messaging, and VIP perks for the ultimate fan experience.',
        ],
        'musician' => [
            'badge' => 'Official Fan Community',
            'title' => '<span class="gradient-text-gold">Front Row</span> to the Show',
            'subtitle' => 'Get early access to music drops, exclusive merch, concert priority, and behind-the-scenes content.',
        ],
    ];
    $catDefaults = $catHeroDefaults[$cat] ?? $catHeroDefaults['musician'];
@endphp

@if ($cat === 'movie_star')
{{-- ─── MOVIE STAR HERO: Cinematic, Red Carpet, Glamour ─── --}}
<section class="relative min-h-0 py-20 md:py-28 flex items-center overflow-hidden" style="background: linear-gradient(135deg, #0a0a0f 0%, #1a1025 30%, #0d0d1a 60%, #000 100%);">
    <div class="absolute inset-0 opacity-10" style="background: radial-gradient(ellipse at 20% 50%, #fbbf24 0%, transparent 60%), radial-gradient(ellipse at 80% 30%, #e11d48 0%, transparent 50%), radial-gradient(ellipse at 50% 80%, #6366f1 0%, transparent 50%);"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.03\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); opacity: 0.4;"></div>
    <div class="absolute top-10 left-10 w-96 h-96 rounded-full opacity-[0.08] animate-float" style="background: conic-gradient(from 0deg, #fbbf24, #e11d48, #6366f1, #fbbf24); filter: blur(80px);"></div>
    <div class="absolute bottom-20 right-10 w-[500px] h-[500px] rounded-full opacity-[0.06] animate-blob-reverse" style="background: radial-gradient(circle, #e11d48, transparent); filter: blur(100px);"></div>
    <div class="absolute inset-0" style="background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.02) 2px, rgba(255,255,255,0.02) 4px);"></div>

    <div class="relative container-x w-full">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
            <div class="flex-1 text-center md:text-left space-y-4 md:space-y-8">
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-[0.15em]" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.25);">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: #fbbf24;"></span>
                    {{ $content['hero_badge'] ?? $catDefaults['badge'] }}
                </div>
                <h1 class="text-4xl md:text-7xl lg:text-8xl font-bold leading-[1.05] tracking-tight" style="color: #fff;">
                    {!! $content['hero_title'] ?? $catDefaults['title'] !!}
                </h1>
                <p class="text-base md:text-xl max-w-xl leading-relaxed" style="color: rgba(255,255,255,0.6);">
                    {{ $content['hero_subtitle'] ?? $catDefaults['subtitle'] }}
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 md:gap-4 pt-2">
                    @if ($features['membership'] ?? false)
                        <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-bold transition-all duration-300 hover:-translate-y-1 animate-shine" style="background: linear-gradient(135deg, #fbbf24, #e11d48); color: #fff; box-shadow: 0 8px 32px -6px rgba(251,191,36,0.4);">
                            Explore Memberships
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-semibold transition-all duration-300 hover:bg-white/20 hover:-translate-y-1" style="border: 2px solid rgba(255,255,255,0.25); color: #fff;">Join Now</a>
                    @endguest
                    @auth
                        <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-semibold transition-all duration-300 hover:bg-white/20 hover:-translate-y-1" style="border: 2px solid rgba(255,255,255,0.25); color: #fff;">My Dashboard</a>
                    @endauth
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 rounded-3xl opacity-20 blur-3xl" style="background: linear-gradient(135deg, #fbbf24, #e11d48); transform: scale(0.85);"></div>
                    <div class="relative w-64 h-64 md:w-96 md:h-96 rounded-3xl overflow-hidden shadow-2xl" style="box-shadow: 0 30px 80px -20px rgba(251,191,36,0.3); border: 1px solid rgba(255,255,255,0.1);">
                        @if ($celebrity->avatar)
                            <img src="{{ $celebrity->getAvatarUrl() }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-8xl font-bold" style="background: linear-gradient(135deg, #1a1025, #0d0d1a); color: rgba(251,191,36,0.3);">
                                {{ strtoupper(substr($celebrity->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%);"></div>
                    </div>
                    <div class="absolute -bottom-4 -right-4 px-4 py-3 rounded-xl backdrop-blur-xl border border-white/10" style="background: rgba(255,255,255,0.08);">
                        <div class="text-center">
                            <div class="text-2xl font-bold" style="color: #fbbf24;">{{ count($tiers) }}</div>
                            <div class="text-xs font-medium" style="color: rgba(255,255,255,0.5);">Membership Tiers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32" style="background: linear-gradient(to top, var(--page-bg-color, #ffffff), transparent);"></div>
</section>

@elseif ($cat === 'country_singer')
{{-- ─── COUNTRY SINGER HERO: Rustic, Warm, Southern Charm ─── --}}
<section class="relative min-h-0 py-20 md:py-28 flex items-center overflow-hidden" style="background: linear-gradient(180deg, #1c1109 0%, #2d1f14 30%, #1a0f08 60%, #0d0704 100%);">
    <div class="absolute inset-0 opacity-[0.12]" style="background: radial-gradient(ellipse at 30% 20%, #d97706 0%, transparent 50%), radial-gradient(ellipse at 70% 80%, #b45309 0%, transparent 50%), radial-gradient(ellipse at 50% 50%, #78350f 0%, transparent 60%);"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M50 0l10 30h30L65 50l15 30-30-15L20 80l15-30L10 30h30z\" fill=\"rgba(255,255,255,0.02)\" fill-rule=\"evenodd\"/%3E%3C/svg%3E'); background-size: 200px 200px;"></div>
    <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full opacity-[0.06] animate-float" style="background: radial-gradient(circle, #d97706, transparent); filter: blur(60px);"></div>
    <div class="absolute bottom-1/3 right-1/4 w-80 h-80 rounded-full opacity-[0.05] animate-blob-reverse" style="background: radial-gradient(circle, #b45309, transparent); filter: blur(80px);"></div>

    <div class="relative container-x w-full">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
            <div class="flex-1 text-center md:text-left space-y-4 md:space-y-8">
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-[0.15em]" style="background: rgba(217,119,6,0.15); color: #f59e0b; border: 1px solid rgba(217,119,6,0.3);">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: #f59e0b;"></span>
                    {{ $content['hero_badge'] ?? $catDefaults['badge'] }}
                </div>
                <h1 class="text-4xl md:text-7xl lg:text-8xl font-bold leading-[1.05] tracking-tight" style="color: #fff; font-family: 'Georgia', serif;">
                    {!! $content['hero_title'] ?? $catDefaults['title'] !!}
                </h1>
                <p class="text-base md:text-xl max-w-xl leading-relaxed" style="color: rgba(255,255,255,0.55);">
                    {{ $content['hero_subtitle'] ?? $catDefaults['subtitle'] }}
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 md:gap-4 pt-2">
                    @if ($features['membership'] ?? false)
                        <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-bold transition-all duration-300 hover:-translate-y-1" style="background: linear-gradient(135deg, #d97706, #b45309); color: #fff; box-shadow: 0 8px 32px -6px rgba(217,119,6,0.35);">
                            Explore Memberships
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-semibold transition-all duration-300 hover:bg-white/10 hover:-translate-y-1" style="border: 2px solid rgba(245,158,11,0.35); color: #f59e0b;">Join Now</a>
                    @endguest
                    @auth
                        <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-semibold transition-all duration-300 hover:bg-white/10 hover:-translate-y-1" style="border: 2px solid rgba(245,158,11,0.35); color: #f59e0b;">My Dashboard</a>
                    @endauth
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 rounded-3xl opacity-30 blur-3xl" style="background: #d97706; transform: scale(0.85);"></div>
                    <div class="relative w-64 h-64 md:w-96 md:h-96 rounded-3xl overflow-hidden shadow-2xl" style="box-shadow: 0 30px 80px -20px rgba(217,119,6,0.25); border: 1px solid rgba(255,255,255,0.08);">
                        @if ($celebrity->avatar)
                            <img src="{{ $celebrity->getAvatarUrl() }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-8xl font-bold" style="background: linear-gradient(135deg, #2d1f14, #1a0f08); color: rgba(245,158,11,0.3);">
                                {{ strtoupper(substr($celebrity->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 50%);"></div>
                    </div>
                    <div class="absolute -bottom-4 -right-4 px-4 py-3 rounded-xl backdrop-blur-xl border border-white/10" style="background: rgba(255,255,255,0.08);">
                        <div class="text-center">
                            <div class="text-2xl font-bold" style="color: #f59e0b;">{{ count($tiers) }}</div>
                            <div class="text-xs font-medium" style="color: rgba(255,255,255,0.5);">Membership Tiers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32" style="background: linear-gradient(to top, var(--page-bg-color, #ffffff), transparent);"></div>
</section>

@elseif ($cat === 'adult_star')
{{-- ─── ADULT STAR HERO: Sleek, Premium, Dark & Moody ─── --}}
<section class="relative min-h-0 py-20 md:py-28 flex items-center overflow-hidden" style="background: linear-gradient(135deg, #0d0d0d 0%, #1a0d1a 25%, #0d0d12 50%, #120808 75%, #0a0a0a 100%);">
    <div class="absolute inset-0 opacity-[0.07]" style="background: radial-gradient(ellipse at 30% 20%, #ec4899 0%, transparent 50%), radial-gradient(ellipse at 70% 50%, #a855f7 0%, transparent 40%), radial-gradient(ellipse at 50% 80%, #db2777 0%, transparent 50%);"></div>
    <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, rgba(236,72,153,0.5), rgba(168,85,247,0.5), transparent);"></div>
    <div class="absolute bottom-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, rgba(236,72,153,0.3), transparent);"></div>
    <div class="absolute top-20 right-20 w-72 h-72 rounded-full opacity-[0.06] animate-float" style="background: radial-gradient(circle, #ec4899, transparent); filter: blur(80px);"></div>
    <div class="absolute bottom-40 left-20 w-96 h-96 rounded-full opacity-[0.04] animate-blob-reverse" style="background: radial-gradient(circle, #a855f7, transparent); filter: blur(100px);"></div>

    <div class="relative container-x w-full">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
            <div class="flex-1 text-center md:text-left space-y-4 md:space-y-8">
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-[0.2em]" style="background: rgba(236,72,153,0.1); color: #ec4899; border: 1px solid rgba(236,72,153,0.2);">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: #ec4899; box-shadow: 0 0 8px #ec4899;"></span>
                    {{ $content['hero_badge'] ?? $catDefaults['badge'] }}
                </div>
                <h1 class="text-4xl md:text-7xl lg:text-8xl font-bold leading-[1.05] tracking-tight" style="color: #fff;">
                    {!! $content['hero_title'] ?? $catDefaults['title'] !!}
                </h1>
                <p class="text-base md:text-xl max-w-xl leading-relaxed" style="color: rgba(255,255,255,0.5);">
                    {{ $content['hero_subtitle'] ?? $catDefaults['subtitle'] }}
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 md:gap-4 pt-2">
                    @if ($features['membership'] ?? false)
                        <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-bold transition-all duration-300 hover:-translate-y-1 animate-shine" style="background: linear-gradient(135deg, #db2777, #a855f7); color: #fff; box-shadow: 0 8px 32px -6px rgba(219,39,119,0.4);">
                            Explore Memberships
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-semibold transition-all duration-300 hover:-translate-y-1" style="border: 2px solid rgba(236,72,153,0.3); color: #ec4899;">Join Now</a>
                    @endguest
                    @auth
                        <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-10 py-3 md:py-4 rounded-full text-sm md:text-base font-semibold transition-all duration-300 hover:-translate-y-1" style="border: 2px solid rgba(236,72,153,0.3); color: #ec4899;">My Dashboard</a>
                    @endauth
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 rounded-3xl opacity-30 blur-3xl" style="background: linear-gradient(135deg, #db2777, #a855f7); transform: scale(0.85);"></div>
                    <div class="relative w-64 h-64 md:w-96 md:h-96 rounded-3xl overflow-hidden shadow-2xl" style="box-shadow: 0 30px 80px -20px rgba(219,39,119,0.3); border: 1px solid rgba(236,72,153,0.15);">
                        @if ($celebrity->avatar)
                            <img src="{{ $celebrity->getAvatarUrl() }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-8xl font-bold" style="background: linear-gradient(135deg, #1a0d1a, #0d0d12); color: rgba(236,72,153,0.3);">
                                {{ strtoupper(substr($celebrity->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%);"></div>
                    </div>
                    <div class="absolute -bottom-4 -right-4 px-4 py-3 rounded-xl backdrop-blur-xl border border-white/10" style="background: rgba(255,255,255,0.06);">
                        <div class="text-center">
                            <div class="text-2xl font-bold" style="color: #ec4899;">{{ count($tiers) }}</div>
                            <div class="text-xs font-medium" style="color: rgba(255,255,255,0.5);">Membership Tiers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32" style="background: linear-gradient(to top, var(--page-bg-color, #ffffff), transparent);"></div>
</section>

@else
{{-- ─── MUSIC / GENERAL HERO: Energetic, Concert Vibe ─── --}}
<section class="relative min-h-0 py-20 md:py-28 flex items-center overflow-hidden mesh-gradient-deep">
    <div class="absolute inset-0 hero-gradient animate-gradient"></div>
    <div class="absolute top-20 left-10 w-72 h-72 rounded-full opacity-20 animate-float" style="background: var(--accent); filter: blur(60px);"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 rounded-full opacity-20 animate-blob-reverse" style="background: var(--accent-secondary); filter: blur(80px);"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full opacity-10 animate-spin-slow" style="background: conic-gradient(from 0deg, var(--accent), var(--accent-secondary), var(--accent));"></div>

    <div class="relative container-x w-full">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
            <div class="flex-1 text-center md:text-left space-y-4 md:space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold animate-pulse-glow" style="background: var(--accent-soft-bg); color: var(--accent-deep);">
                    <span class="w-2 h-2 rounded-full live-dot" style="background: var(--accent);"></span>
                    {{ $content['hero_badge'] ?? $catDefaults['badge'] }}
                </div>

                <h1 class="text-4xl md:text-7xl lg:text-8xl font-bold text-gray-900 leading-[1.05] tracking-tight">
                    {!! $content['hero_title'] ?? $catDefaults['title'] !!}
                </h1>

                <p class="text-base md:text-xl text-gray-600 max-w-xl leading-relaxed">
                    {{ $content['hero_subtitle'] ?? $catDefaults['subtitle'] }}
                </p>

                <div class="flex flex-wrap justify-center md:justify-start gap-3 md:gap-4 pt-2">
                    @if ($features['membership'] ?? false)
                        <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="btn-primary !px-6 md:!px-10 !py-3 md:!py-4 !text-sm md:!text-base animate-shine">
                            Explore Memberships
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                    @guest
                        <a href="{{ route('register') }}" class="btn-ghost !px-6 md:!px-10 !py-3 md:!py-4 !text-sm md:!text-base animate-shine">Join Now</a>
                    @endguest
                    @auth
                        <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="btn-ghost !px-6 md:!px-10 !py-3 md:!py-4 !text-sm md:!text-base animate-shine">My Dashboard</a>
                    @endauth
                </div>
            </div>

            <div class="flex-1 flex justify-center">
                <div class="relative animate-pulse-scale">
                    <div class="absolute inset-0 rounded-3xl opacity-30 blur-2xl" style="background: var(--accent); transform: scale(0.85);"></div>
                    <div class="relative w-64 h-64 md:w-96 md:h-96 rounded-3xl overflow-hidden shadow-2xl ring-2 ring-white/20" style="box-shadow: 0 30px 80px -20px var(--accent-glow);">
                        @if ($celebrity->avatar)
                            <img src="{{ $celebrity->getAvatarUrl() }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                        @elseif ($celebrity->cover_photo)
                            <img src="{{ $celebrity->getCoverUrl() }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-8xl font-bold gradient-text">
                                {{ strtoupper(substr($celebrity->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute inset-0" style="background: linear-gradient(to top, color-mix(in srgb, var(--accent) 40%, transparent) 0%, transparent 50%);"></div>
                    </div>
                    <div class="price-badge absolute -bottom-4 -right-4 w-24 h-24 rounded-2xl flex items-center justify-center text-white font-bold text-sm shadow-lg" style="background: var(--accent-gradient);">
                        <div class="text-center leading-tight">
                            <span class="block text-2xl">{{ count($tiers) }}</span>
                            <span class="text-xs opacity-80">Tiers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
</section>
@endif
