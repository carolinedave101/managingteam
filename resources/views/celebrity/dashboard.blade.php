<x-app-layout>
    @php
        $c = $celebrity->config;
        $features = $c['features'] ?? [];
        $hasMembership = (bool) $membership;
        $hasApplication = (bool) $application && $application->status === 'approved';
        $hasCard = (bool) $card;
        $hasMeetups = $meetups->count() > 0;
        $hasTickets = $tickets->count() > 0;

        $onboardingSteps = [
            ['key' => 'register', 'label' => 'Create Account', 'done' => true, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['key' => 'apply', 'label' => 'Fan Application', 'done' => $hasApplication || ($application && $application->status !== 'rejected'), 'route' => 'celebrity.apply', 'pending' => $application && $application->status === 'pending', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['key' => 'membership', 'label' => 'Choose Membership', 'done' => $hasMembership, 'route' => 'celebrity.membership', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['key' => 'card', 'label' => 'Get Membership Card', 'done' => $hasCard, 'route' => 'celebrity.membership-card', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
            ['key' => 'events', 'label' => 'Attend Events', 'done' => $hasTickets || $hasMeetups, 'route' => 'celebrity.meet-greet', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ];
        $completedSteps = collect($onboardingSteps)->filter(fn($s) => $s['done'])->count();
        $totalSteps = count($onboardingSteps);
        $progressPct = round(($completedSteps / $totalSteps) * 100);
    @endphp
    <div class="mesh-gradient min-h-screen relative overflow-hidden">
        {{-- Decorative floating elements --}}
        <div class="animate-float absolute top-20 left-10 w-32 h-32 bg-pink-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="animate-blob absolute top-40 right-20 w-40 h-40 bg-purple-400/10 rounded-full blur-3xl pointer-events-none" style="animation-delay: 2s;"></div>
        <div class="animate-float absolute bottom-40 left-1/4 w-36 h-36 bg-amber-400/10 rounded-full blur-3xl pointer-events-none" style="animation-delay: 4s;"></div>

        <div class="max-w-7xl mx-auto px-4 py-8 relative">

            {{-- ═══ ONBOARDING PROGRESS ═══ --}}
            <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-6 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-5">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            @if ($celebrity->avatar)
                                <img src="{{ $celebrity->avatar }}" alt="{{ $celebrity->name }}" class="w-14 h-14 rounded-full object-cover shadow-lg ring-2 ring-white/60">
                            @else
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white text-xl font-bold shadow-lg ring-2 ring-white/60">
                                    {{ strtoupper(substr($celebrity->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-500 border-2 border-white rounded-full animate-pulse-glow"></span>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                                Hey there, {{ $user->name }}! <span class="wave">👋</span>
                            </h1>
                            <div class="flex items-center flex-wrap gap-x-2 gap-y-1 mt-1">
                                <span class="text-sm text-gray-500">{{ $celebrity->name }} Fan Portal</span>
                                <span class="text-gray-300 hidden sm:inline">·</span>
                                @if ($membership)
                                    <span class="pill text-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse-glow"></span>
                                        {{ ucfirst($membership->tier) }} Member
                                    </span>
                                @elseif ($application && $application->status === 'approved')
                                    <span class="pill text-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse-glow"></span>
                                        Verified Fan
                                    </span>
                                @elseif ($application && $application->status === 'pending')
                                    <span class="pill text-xs" style="background-color: rgba(234,179,8,0.12); color: #a16207;">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        Pending Review
                                    </span>
                                @else
                                    <span class="pill text-xs" style="background-color: rgba(107,114,128,0.1); color: #6b7280;">
                                        Guest
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="sm:ml-auto flex items-center gap-3">
                        <a href="{{ route('celebrity.profile.edit', ['celebrity' => $celebrity->slug]) }}" class="btn-ghost !py-2 !px-4 text-xs animate-shine">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Edit Profile
                        </a>
                    </div>
                </div>

                {{-- Progress bar --}}
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-semibold text-gray-700">Your Journey</p>
                        <span class="text-xs font-medium gradient-text-gold">{{ $completedSteps }}/{{ $totalSteps }} completed</span>
                    </div>
                    <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden relative">
                        <div class="h-full rounded-full transition-all duration-1000 ease-out relative overflow-hidden" style="width: {{ $progressPct }}%; background: var(--accent-gradient);">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shine"></div>
                        </div>
                    </div>
                </div>

                {{-- Steps --}}
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 sm:gap-3">
                    @foreach ($onboardingSteps as $i => $step)
                        @php
                            $isDone = $step['done'];
                            $isPending = $step['pending'] ?? false;
                            $stepColor = $isDone ? 'text-green-600 bg-green-100' : ($isPending ? 'text-yellow-600 bg-yellow-100' : 'text-gray-400 bg-gray-100');
                            $labelColor = $isDone ? 'text-green-700' : ($isPending ? 'text-yellow-700' : 'text-gray-400');
                        @endphp
                        <div class="text-center p-2 rounded-xl transition hover:bg-white/50 {{ $isDone ? '' : 'opacity-70' }} {{ $isDone || $isPending ? 'step-glow' : '' }}">
                            <div class="w-8 h-8 mx-auto rounded-full {{ $stepColor }} flex items-center justify-center mb-1.5 {{ $isPending ? 'animate-pulse-glow' : '' }}">
                                @if ($isDone)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @elseif ($isPending)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2"/></svg>
                                @endif
                            </div>
                            <p class="text-[11px] font-semibold {{ $labelColor }} leading-tight">{{ $step['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- ═══ QUICK ACTIONS ═══ --}}
            <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-6 mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 animate-pulse-glow" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <h2 class="text-base font-bold text-gray-900">Quick Actions</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if ($features['membership'] ?? false)
                        <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:-translate-y-0.5 shadow-sm bg-gradient-to-r from-pink-500 to-rose-600 text-white animate-shine"
                           {{-- style="background: var(--accent-soft-bg); color: var(--accent-deep);" --}}>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            {{ $membership ? 'Manage Membership' : 'Choose Plan' }}
                        </a>
                    @endif
                    @if ($features['meet_greet'] ?? false)
                        <a href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:-translate-y-0.5 shadow-sm animate-shine"
                           style="background: rgba(139,92,246,0.1); color: #7c3aed;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Browse Events
                        </a>
                    @endif
                    @if ($features['membership_card'] ?? false)
                        <a href="{{ route('celebrity.membership-card', ['celebrity' => $celebrity->slug]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:-translate-y-0.5 shadow-sm animate-shine"
                           style="background: rgba(99,102,241,0.1); color: #4f46e5;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            {{ $card ? 'View Card' : 'Order Card' }}
                        </a>
                    @endif
                    @if ($features['private_meetup'] ?? false)
                        <a href="{{ route('celebrity.private-meetup', ['celebrity' => $celebrity->slug]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:-translate-y-0.5 shadow-sm animate-shine"
                           style="background: rgba(20,184,166,0.1); color: #0d9488;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a3 3 0 003-3V8a3 3 0 00-3-3H5a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            Book Meetup
                        </a>
                    @endif
                    <a href="{{ route('celebrity.wallet', ['celebrity' => $celebrity->slug]) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:-translate-y-0.5 shadow-sm animate-shine"
                       style="background: rgba(16,185,129,0.1); color: #059669;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Wallet <span class="price-glow">${{ number_format($wallet->balance, 2) }}</span>
                    </a>
                    @if (!$application || $application->status !== 'approved')
                        <a href="{{ route('celebrity.apply', ['celebrity' => $celebrity->slug]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:-translate-y-0.5 shadow-sm animate-shine"
                           style="background: rgba(245,158,11,0.1); color: #b45309;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ $application ? 'View Application' : 'Apply Now' }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- ═══ STATS ROW ═══ --}}
            <div class="flex flex-wrap justify-center gap-4 mb-8 [&>*]:grow [&>*]:basis-48 [&>*]:max-w-xs">
                <div class="reveal is-visible reveal-delay-1 glass-strong rounded-2xl border border-white/60 shadow-lg hover:shadow-xl transition-all duration-300 p-4 flex items-center gap-3 card-hover ring-glow-hover">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 shadow-lg shadow-pink-200/50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Membership</p>
                        <p class="text-base font-bold {{ $membership ? 'gradient-text-gold' : 'text-gray-900' }}">{{ $membership ? ucfirst($membership->tier) : 'None' }}</p>
                    </div>
                </div>
                <div class="reveal is-visible reveal-delay-2 glass-strong rounded-2xl border border-white/60 shadow-lg hover:shadow-xl transition-all duration-300 p-4 flex items-center gap-3 card-hover ring-glow-hover">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-400 to-violet-500 shadow-lg shadow-purple-200/50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Inbox</p>
                        <div class="flex items-baseline gap-1.5">
                            <p class="text-base font-bold text-gray-900 count-highlight">{{ $messages->count() }}</p>
                            @if ($unreadCount > 0)
                                <span class="text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded-full animate-pulse-glow">{{ $unreadCount }} new</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="reveal is-visible reveal-delay-3 glass-strong rounded-2xl border border-white/60 shadow-lg hover:shadow-xl transition-all duration-300 p-4 flex items-center gap-3 card-hover ring-glow-hover">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-amber-200/50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Application</p>
                        <p class="text-base font-bold text-gray-900">{{ $application ? ucfirst($application->status) : 'Not Submitted' }}</p>
                    </div>
                </div>
                <a href="{{ route('celebrity.wallet', ['celebrity' => $celebrity->slug]) }}"
                   class="reveal is-visible reveal-delay-4 glass-strong rounded-2xl border border-white/60 shadow-lg hover:shadow-xl transition-all duration-300 p-4 flex items-center gap-3 card-hover ring-glow-hover group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg shadow-emerald-200/50 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Wallet</p>
                        <p class="text-base font-bold gradient-text-gold" data-wallet-balance>${{ number_format($wallet->balance, 2) }}</p>
                    </div>
                </a>
                <div class="reveal is-visible reveal-delay-4 glass-strong rounded-2xl border border-white/60 shadow-lg hover:shadow-xl transition-all duration-300 p-4 flex items-center gap-3 card-hover ring-glow-hover">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-400 to-cyan-500 shadow-lg shadow-sky-200/50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Tickets</p>
                        <p class="text-base font-bold text-gray-900 count-highlight">{{ $tickets->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- ═══ FEATURE GRID ═══ --}}
            <div class="flex flex-wrap justify-center gap-5 mb-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                @if ($features['fan_applications'] ?? false)
                    <div class="reveal is-visible group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover ring-glow-hover">
                        <div class="feature-card-header feature-accent-amber"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                @if ($application)
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full
                                        {{ $application->status === 'approved' ? 'bg-green-100 text-green-700' : ($application->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                @else
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">Not started</span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Fan Application</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                @if ($application && $application->status === 'approved')
                                    You're a verified fan! Full access granted.
                                @elseif ($application && $application->status === 'pending')
                                    Your application is being reviewed. We'll notify you as soon as it's processed.
                                @elseif ($application && $application->status === 'rejected')
                                    Your application wasn't approved. Contact the team for more info.
                                @else
                                    Submit your application to become a verified fan and unlock all features.
                                @endif
                            </p>
                            @if (!$application || $application->status !== 'approved')
                                <a href="{{ route('celebrity.apply', ['celebrity' => $celebrity->slug]) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-600 hover:text-amber-700 group/link animate-shine">
                                    <span>{{ $application ? 'View Status' : 'Apply Now' }}</span>
                                    <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($features['membership'] ?? false)
                    <div class="reveal is-visible group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover ring-glow-hover">
                        <div class="feature-card-header feature-accent-pink"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                @if ($membership)
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-700">Active</span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Membership</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                @if ($membership)
                                    You're on the <strong class="text-gray-900">{{ $membership->tier }}</strong> plan at <strong class="text-gray-900 price-glow">${{ number_format($membership->price, 2) }}</strong>/mo.
                                    Ready to upgrade or make changes? Head to the membership page.
                                @else
                                    Choose a membership tier to unlock exclusive content, perks, and VIP access.
                                @endif
                            </p>
                            <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-pink-600 hover:text-pink-700 group/link animate-shine">
                                <span>{{ $membership ? 'Manage Plan' : 'View Tiers' }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endif

                @if ($features['meet_greet'] ?? false)
                    <div class="reveal is-visible group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover ring-glow-hover">
                        <div class="feature-card-header feature-accent-purple"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-100 to-violet-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                @if ($tickets->count())
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-purple-100 text-purple-700">{{ $tickets->count() }} ticket{{ $tickets->count() !== 1 ? 's' : '' }}</span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Meet &amp; Greet</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                @if ($upcomingEvents->count())
                                    <strong class="text-gray-900 count-highlight">{{ $upcomingEvents->count() }}</strong> upcoming {{ Str::plural('event', $upcomingEvents->count()) }} — grab your tickets quickly before they sell out!
                                @else
                                    Get up close and personal at exclusive meet & greet events. Check back for new dates.
                                @endif
                            </p>
                            <a href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-600 hover:text-purple-700 group/link animate-shine">
                                <span>{{ $tickets->count() ? 'Browse Events' : 'View Events' }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endif

                @if ($features['membership_card'] ?? false)
                    <div class="reveal is-visible group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover ring-glow-hover">
                        <div class="feature-card-header feature-accent-indigo"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                @if ($card)
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $card->is_active ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $card->is_active ? 'Active' : 'Pending' }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Membership Card</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                @if ($card)
                                    Card <strong class="text-gray-900">{{ $card->card_number }}</strong> — {{ $card->is_active ? 'ready to use at events' : 'awaiting approval from the team' }}.
                                @else
                                    Order your exclusive digital membership card to show your fandom and unlock VIP access.
                                @endif
                            </p>
                            <a href="{{ route('celebrity.membership-card', ['celebrity' => $celebrity->slug]) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700 group/link animate-shine">
                                <span>{{ $card ? 'View Card' : 'Order Card' }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endif

                @if ($features['private_meetup'] ?? false)
                    <div class="reveal is-visible group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover ring-glow-hover">
                        <div class="feature-card-header feature-accent-teal"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-teal-100 to-cyan-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a3 3 0 003-3V8a3 3 0 00-3-3H5a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                @if ($meetups->count())
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full
                                        {{ $meetups->first()->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($meetups->first()->status === 'completed' ? 'bg-gray-100 text-gray-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ ucfirst($meetups->first()->status) }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Private Meetup</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                @if ($meetups->count())
                                    You have {{ $meetups->count() }} meetup{{ $meetups->count() !== 1 ? 's' : '' }} — latest is <strong class="text-gray-900">{{ $meetups->first()->status }}</strong>.
                                @else
                                    Request a private one-on-one meetup for an unforgettable experience with {{ $celebrity->name }}.
                                @endif
                            </p>
                            <a href="{{ route('celebrity.private-meetup', ['celebrity' => $celebrity->slug]) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-600 hover:text-teal-700 group/link animate-shine">
                                <span>{{ $meetups->count() ? 'View Meetups' : 'Request Now' }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endif

                @if ($features['messaging'] ?? false)
                    <div class="reveal is-visible group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover ring-glow-hover">
                        <div class="feature-card-header feature-accent-rose"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                @if ($unreadCount > 0)
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-700 animate-pulse-glow">{{ $unreadCount }} unread</span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Messages</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                @if ($messages->count())
                                    You have {{ $messages->count() }} {{ Str::plural('message', $messages->count()) }}. Need to ask something? Send a message to the team.
                                @else
                                    No messages yet. Start a conversation with the {{ $celebrity->name }} management team.
                                @endif
                            </p>
                            <a href="{{ route('celebrity.messages', ['celebrity' => $celebrity->slug]) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:text-rose-700 group/link animate-shine">
                                <span>Open Inbox</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Wallet card --}}
                <div class="reveal is-visible group bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover ring-glow-hover">
                    <div class="feature-card-header feature-accent-emerald"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 price-badge" data-wallet-balance>${{ number_format($wallet->balance, 2) }}</span>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1">Wallet</h3>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                            Your wallet balance is <strong class="text-gray-900 price-glow" data-wallet-balance>${{ number_format($wallet->balance, 2) }}</strong>.
                            Use wallet credits to pay for memberships, events, and services instantly — no upload needed!
                        </p>
                        <a href="{{ route('celebrity.wallet', ['celebrity' => $celebrity->slug]) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 group/link animate-shine">
                            <span>Manage Wallet</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- ═══ BOTTOM: QUICK MESSAGE + UPCOMING EVENTS ═══ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Quick message compose --}}
                <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-rose-600 animate-pulse-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-gray-900">Quick Message</h2>
                                <p class="text-xs text-gray-400">Have a question? Send a message to the team.</p>
                            </div>
                        </div>
                        <a href="{{ route('celebrity.messages', ['celebrity' => $celebrity->slug]) }}" class="text-xs font-semibold text-rose-600 hover:text-rose-700 transition animate-shine">Full Inbox →</a>
                    </div>
                    <form method="POST" action="{{ route('celebrity.messages.store', ['celebrity' => $celebrity->slug]) }}"
                          novalidate x-data="formValidation">
                        @csrf
                        <div class="space-y-3">
                            <input type="text" name="subject" required placeholder="What's this about?"
                                   x-on:input.debounce.300ms="validate('subject', $el.value, [validators.required])"
                                   x-on:blur="validate('subject', $el.value, [validators.required])"
                                   x-bind:class="inputClass('subject')"
                                   class="form-input">
                            <template x-if="invalid('subject')">
                                <p x-text="errors.subject" class="text-red-500 text-xs mt-1"></p>
                            </template>
                            <textarea name="content" rows="3" required placeholder="Write your message to the {{ $celebrity->name }} team..."
                                      x-on:input.debounce.300ms="validate('content', $el.value, [validators.required, validators.minLength(10)])"
                                      x-on:blur="validate('content', $el.value, [validators.required, validators.minLength(10)])"
                                      x-bind:class="inputClass('content')"
                                      class="form-input"></textarea>
                            <template x-if="invalid('content')">
                                <p x-text="errors.content" class="text-red-500 text-xs mt-1"></p>
                            </template>
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-rose-500 to-pink-600 text-white py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 shadow-md animate-shine">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Send Message
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Upcoming events --}}
                <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-violet-100 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-purple-600 animate-pulse-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-gray-900">Upcoming Events</h2>
                                <p class="text-xs text-gray-400">Don't miss out — grab your tickets now.</p>
                            </div>
                        </div>
                        @if ($features['meet_greet'] ?? false)
                            <a href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}" class="text-xs font-semibold text-purple-600 hover:text-purple-700 transition animate-shine">All Events →</a>
                        @endif
                    </div>
                    @if ($upcomingEvents->count())
                        <div class="space-y-3">
                            @foreach ($upcomingEvents as $event)
                                <div class="flex items-center gap-4 p-3.5 rounded-xl bg-gray-50/50 hover:bg-gray-100/80 transition border border-gray-100/50 group ring-glow-hover">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center shrink-0 shadow-sm">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-gray-900 text-sm">{{ $event->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $event->date->format('D, M j · g:i A') }} · {{ $event->location }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-base font-bold text-pink-600 price-glow">${{ number_format($event->price, 0) }}</p>
                                        <span class="text-xs text-gray-400">per ticket</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400 animate-pulse-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="font-semibold text-gray-500 text-sm">No upcoming events</p>
                            <p class="text-xs text-gray-400 mt-1">Check back soon for new events.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .wave { display: inline-block; animation: wave 2s ease-in-out infinite; transform-origin: 70% 70%; }
        @@keyframes wave { 0%, 100% { transform: rotate(0deg); } 10% { transform: rotate(16deg); } 20% { transform: rotate(-6deg); } 30% { transform: rotate(12deg); } 40% { transform: rotate(-4deg); } 50% { transform: rotate(8deg); } 60% { transform: rotate(0deg); } }
    </style>
</x-app-layout>
