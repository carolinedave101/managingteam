<x-app-layout>
    @php
        $c = $celebrity->config;
        $content = $c['site_content'] ?? [];
        $features = $c['features'] ?? [];
        $tiers = $c['membership_tiers'] ?? [];
        $payments = $celebrity->enabledPaymentMethods;
        $theme = $c['theme'] ?? [];
    @endphp

    {{-- ─── HERO ─── --}}
    <section class="relative min-h-[90vh] flex items-center overflow-hidden mesh-gradient-deep">
        <div class="absolute inset-0 hero-gradient animate-gradient"></div>
        <div class="absolute top-20 left-10 w-72 h-72 rounded-full opacity-20 animate-float" style="background: var(--accent); filter: blur(60px);"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 rounded-full opacity-20 animate-blob-reverse" style="background: var(--accent-secondary); filter: blur(80px);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full opacity-10 animate-spin-slow" style="background: conic-gradient(from 0deg, var(--accent), var(--accent-secondary), var(--accent));"></div>

        <div class="relative container-x w-full">
            <div class="flex flex-col md:flex-row items-center gap-16">
                <div class="flex-1 text-center md:text-left space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold animate-pulse-glow" style="background: var(--accent-soft-bg); color: var(--accent-deep);">
                        <span class="w-2 h-2 rounded-full live-dot" style="background: var(--accent);"></span>
                        Official Fan Community
                    </div>

                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-gray-900 leading-[1.05] tracking-tight">
                        {!! $content['hero_title'] ?? '<span class="gradient-text-gold">Welcome</span> to the<br>Fan Community' !!}
                    </h1>

                    <p class="text-lg md:text-xl text-gray-600 max-w-xl leading-relaxed">
                        {{ $content['hero_subtitle'] ?? 'Join the most exclusive fan community. Access premium content, attend events, and connect with the community.' }}
                    </p>

                    <div class="flex flex-wrap justify-center md:justify-start gap-4 pt-2">
                        @if ($features['membership'] ?? false)
                            <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="btn-primary !px-10 !py-4 !text-base animate-shine">
                                Explore Memberships
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        @endif
                        @guest
                            <a href="{{ route('register') }}" class="btn-ghost !px-10 !py-4 !text-base animate-shine">Join Now</a>
                        @endguest
                        @auth
                            <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="btn-ghost !px-10 !py-4 !text-base animate-shine">My Dashboard</a>
                        @endauth
                    </div>
                </div>

                <div class="flex-1 flex justify-center">
                    <div class="relative animate-pulse-scale">
                        <div class="absolute inset-0 rounded-3xl opacity-30 blur-2xl" style="background: var(--accent); transform: scale(0.85);"></div>
                        <div class="relative w-80 h-80 md:w-96 md:h-96 rounded-3xl overflow-hidden shadow-2xl ring-2 ring-white/20" style="box-shadow: 0 30px 80px -20px var(--accent-glow);">
                            @if ($celebrity->avatar)
                                <img src="{{ $celebrity->avatar }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                            @elseif ($celebrity->cover_photo)
                                <img src="{{ $celebrity->cover_photo }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
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

    <div class="section-divider"></div>

    {{-- ─── STATS ─── --}}
    <section class="relative -mt-16 container-x z-10">
        <div class="glass-strong rounded-2xl p-8 md:p-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @php
                    $stats = $content['stats'] ?? [
                        ['value' => '10M+', 'label' => 'Global Fans'],
                        ['value' => '50+', 'label' => 'Events Held'],
                        ['value' => '3', 'label' => 'Studio Albums'],
                        ['value' => '8', 'label' => 'Years Active'],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="space-y-1">
                        <div class="text-3xl md:text-4xl font-bold count-highlight">{{ $stat['value'] }}</div>
                        <div class="text-sm text-gray-500 font-medium">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── ABOUT ─── --}}
    <section class="section">
        <div class="container-x">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="eyebrow">About</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        {{ $content['about_title'] ?? 'The Story Behind ' . $celebrity->name }}
                    </h2>
                    <div class="text-gray-600 leading-relaxed space-y-4 text-lg">
                        {!! $content['about_body'] ?? '<p>' . $celebrity->name . ' is a global artist and performer. This is the official fan community where you can connect, share, and experience exclusive moments together.</p>' !!}
                    </div>
                    <div class="flex gap-4 pt-2">
                        @if ($celebrity->social_links['instagram'] ?? false)
                            <a href="{{ $celebrity->social_links['instagram'] }}" target="_blank" class="flex items-center gap-2 text-sm font-semibold transition hover:translate-x-1" style="color: var(--accent);">
                                Follow on Instagram
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-xl">
                        @if ($celebrity->cover_photo)
                            <img src="{{ $celebrity->cover_photo }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full mesh-gradient flex items-center justify-center">
                                <span class="text-9xl font-bold gradient-text opacity-50">{{ strtoupper(substr($celebrity->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 rounded-2xl flex items-center justify-center shadow-lg border border-white/20 text-white" style="background: var(--accent-gradient);">
                        <div class="text-center">
                            <div class="text-3xl font-bold">{{ date('Y') - 2016 }}</div>
                            <div class="text-xs opacity-80">Years</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    {{-- ─── FEATURES ─── --}}
    @if (collect($features)->filter()->isNotEmpty())
    <section class="section" style="background: var(--accent-light);">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">Features</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">Everything for <span class="gradient-text-gold">Real Fans</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Premium features designed to bring you closer to the moments and the community.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                @php
                    $featureIcons = [
                        'membership' => ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Membership Tiers', 'Choose from exclusive membership tiers. Each level unlocks unique perks and privileges.'],
                        'meet_greet' => ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Meet & Greet', 'Attend exclusive events. Get tickets to intimate meet & greet sessions with the celebrity.'],
                        'membership_card' => ['M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'Membership Card', 'Get your exclusive digital membership card for VIP access at all events.'],
                        'private_meetup' => ['M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Private Meetups', 'Request one-on-one private meetups for an unforgettable personal experience.'],
                        'messaging' => ['M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'Direct Messaging', 'Send messages directly to the management team. We\'re here for you always.'],
                        'fan_applications' => ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Fan Applications', 'Apply to become a verified fan and unlock the full community experience.'],
                    ];
                    $featureNames = [
                        'membership' => 'Membership',
                        'meet_greet' => 'Meet & Greet',
                        'membership_card' => 'Membership Card',
                        'private_meetup' => 'Private Meetup',
                        'messaging' => 'Messaging',
                        'fan_applications' => 'Fan Applications',
                    ];
                    $featureRoutePrefixes = [
                        'membership' => 'celebrity.membership',
                        'meet_greet' => 'celebrity.meet-greet',
                        'membership_card' => 'celebrity.membership-card',
                        'private_meetup' => 'celebrity.private-meetup',
                        'messaging' => 'celebrity.messages',
                        'fan_applications' => 'celebrity.apply',
                    ];
                @endphp
                @foreach ($features as $key => $enabled)
                    @if ($enabled && isset($featureIcons[$key]))
                        @php $icon = $featureIcons[$key]; @endphp
                        <a href="{{ route($featureRoutePrefixes[$key] ?? 'celebrity.home', ['celebrity' => $celebrity->slug]) }}" class="group card-glow bg-white rounded-2xl p-8 border shadow-sm hover:shadow-xl" style="border-color: color-mix(in srgb, var(--accent) 12%, transparent);">
                            <div class="feature-card-header w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-transform group-hover:scale-110" style="background: var(--accent-soft-bg); color: var(--accent-deep);">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon[0] }}"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $icon[1] }}</h3>
                            <p class="text-gray-500 leading-relaxed">{{ $icon[2] }}</p>
                            <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold transition group-hover:gap-2 animate-shine" style="color: var(--accent);">
                                Learn more
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <div class="section-divider"></div>

    {{-- ─── MEMBERSHIP TIERS ─── --}}
    @if (($features['membership'] ?? false) && count($tiers))
    <section class="section">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">Pricing</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">Choose Your <span class="gradient-text-gold">Tier</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Select the membership that fits your passion. Upgrade anytime.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6 [&>*]:grow [&>*]:basis-60 [&>*]:max-w-sm">
                @foreach ($tiers as $tier)
                    <div class="group relative bg-white rounded-2xl p-8 border shadow-sm transition-all duration-300 hover:-translate-y-2 card-glow ring-glow-hover" style="border-color: color-mix(in srgb, var(--accent) 15%, transparent);">
                        <div class="w-12 h-1 rounded-full mb-6" style="background: {{ $tier['color'] ?? $theme['primary_color'] ?? 'var(--accent)' }};"></div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $tier['name'] }}</h3>
                        <div class="mb-6">
                            <span class="price-glow text-4xl font-bold text-gray-900">${{ number_format($tier['price'], 0) }}</span>
                            <span class="text-gray-400 text-sm">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            @foreach ($tier['benefits'] ?? [] as $benefit)
                                <li class="flex items-start gap-3 text-sm text-gray-600">
                                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $benefit }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="btn-primary w-full text-center cta-pulse">
                            Get Started
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <div class="section-divider"></div>

    {{-- ─── UPCOMING EVENTS ─── --}}
    @if ($features['meet_greet'] ?? false)
    @php
        $events = \App\Models\MeetGreetEvent::where('celebrity_id', $celebrity->id)
            ->where('is_active', true)
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();
    @endphp
    @if ($events->count())
    <section class="section" style="background: var(--accent-light);">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">Events</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">Upcoming <span class="gradient-text-gold">Events</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Don't miss your chance to meet the celebrity in person.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                @foreach ($events as $event)
                    <div class="group bg-white rounded-2xl overflow-hidden border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 card-glow" style="border-color: color-mix(in srgb, var(--accent) 12%, transparent);">
                        <div class="h-48 relative overflow-hidden" style="background: var(--accent-gradient);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <div class="text-5xl font-bold">{{ $event->date->format('d') }}</div>
                                    <div class="text-lg font-semibold opacity-80">{{ $event->date->format('M Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:accent-text transition">{{ $event->title }}</h3>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->location }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <span class="price-glow">${{ number_format($event->price, 0) }}</span>
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed">{{ $event->description }}</p>
                            @auth
                                <a href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}" class="btn-primary w-full text-center">Get Tickets</a>
                            @else
                                <a href="{{ route('register') }}" class="btn-ghost w-full text-center">Join to Attend</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @endif

    <div class="section-divider"></div>

    {{-- ─── TESTIMONIALS ─── --}}
    @if (count($content['testimonials'] ?? []))
    <section class="section">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">Testimonials</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">What <span class="gradient-text-gold">Fans Say</span></h2>
            </div>

            <div class="flex flex-wrap justify-center gap-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                @foreach ($content['testimonials'] as $testimonial)
                    <div class="card-glow bg-white rounded-2xl p-8 border shadow-sm hover:shadow-lg transition-all duration-300" style="border-color: color-mix(in srgb, var(--accent) 12%, transparent);">
                        <div class="flex gap-1 mb-6">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" style="color: var(--accent);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $testimonial['quote'] ?? '' }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold" style="background: var(--accent-gradient);">
                                {{ strtoupper(substr($testimonial['author'] ?? 'F', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $testimonial['author'] ?? '' }}</p>
                                @if ($testimonial['badge'] ?? false)
                                    <p class="text-xs font-medium" style="color: var(--accent);">{{ $testimonial['badge'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── CTA ─── --}}
    <section class="relative overflow-hidden py-28" style="background: var(--accent-gradient);">
        <div class="absolute inset-0 opacity-10 banner-gradient">
            <div class="absolute top-10 left-10 w-40 h-40 rounded-full bg-white animate-float"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 rounded-full bg-white animate-blob-reverse"></div>
            <div class="absolute top-1/2 left-1/2 w-80 h-80 rounded-full bg-white/20 animate-spin-slow"></div>
        </div>
        <div class="relative container-x text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Ready to Join <span class="opacity-80">{{ $celebrity->name }}'s</span> Community?
            </h2>
            <p class="text-white/80 text-lg mb-10 max-w-xl mx-auto">Start your journey as a verified fan. Choose a membership tier and unlock exclusive perks.</p>
            <div class="flex flex-wrap justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-gray-900 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300 cta-pulse animate-shine">
                        Create Your Account
                    </a>
                @endguest
                @auth
                    <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="bg-white text-gray-900 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300 cta-pulse animate-shine">
                        View Membership Plans
                    </a>
                @endauth
                @if ($celebrity->social_links['instagram'] ?? false)
                    <a href="{{ $celebrity->social_links['instagram'] }}" target="_blank" class="border-2 border-white/40 text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-white/10 hover:border-white/70 transition-all duration-300">
                        Follow on Instagram
                    </a>
                @endif
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.counter').forEach(el => {
            const target = parseInt(el.dataset.target);
            const duration = 2000;
            const step = Math.ceil(target / (duration / 16));
            let current = 0;
            const update = () => {
                current += step;
                if (current >= target) { el.textContent = target; return; }
                el.textContent = current;
                requestAnimationFrame(update);
            };
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    update();
                    observer.unobserve(el);
                }
            }, { threshold: 0.5 });
            observer.observe(el);
        });
    </script>
</x-app-layout>
