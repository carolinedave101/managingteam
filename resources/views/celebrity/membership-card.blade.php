<x-app-layout>
    @php
        $theme = $celebrity->config['theme'] ?? [];
        $primaryColor = $theme['primary_color'] ?? '#ec4899';
        $secondaryColor = $theme['secondary_color'] ?? '#8b5cf6';
        $cardFee = $celebrity->config['pricing']['membership_card_fee'] ?? 0;
    @endphp
    <div class="min-h-screen py-12 relative overflow-hidden" style="background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #eef2ff 100%);">
        <div class="max-w-3xl mx-auto px-4 relative">
            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm ring-2 ring-indigo-200/50">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Membership <span style="background:linear-gradient(135deg,{{ $primaryColor }},{{ $secondaryColor }});-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Card</span></h1>
            </div>

            {{-- Gift Card --}}
            <div class="max-w-xl mx-auto mb-8"
                 x-data="card3d()"
                 x-init="init()"
                 @mousemove.capture="onMove"
                 @mouseleave.capture="onLeave"
                 @touchmove.capture="onTouchMove"
                 @touchend.capture="onLeave">
                <div class="scene" :class="{ 'is-spinning': spinning }">
                    <div class="card-3d" x-ref="card3d" @click="toggleSpin">

                        {{-- Front --}}
                        <div class="card-face card-front">
                            <div class="h-full flex flex-col">
                                {{-- Top branding bar --}}
                                <div class="bg-black/20 px-5 sm:px-7 py-2.5 flex items-center justify-between">
                                    <span class="text-[10px] tracking-[0.25em] uppercase text-white/60 font-mono font-semibold">Gift Card</span>
                                    <span class="text-[10px] tracking-[0.25em] uppercase text-white/60 font-mono">{{ $celebrity->name }}</span>
                                </div>

                                <div class="flex-1 flex flex-col justify-center px-5 sm:px-7 py-4">
                                    @if ($card)
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $card->is_active ? 'bg-emerald-400' : 'bg-amber-400' }}"></span>
                                            <span class="text-[10px] font-semibold tracking-wider uppercase {{ $card->is_active ? 'text-emerald-300' : 'text-amber-300' }}">{{ $card->is_active ? 'Redeemed' : 'Pending' }}</span>
                                        </div>
                                        <p class="text-lg sm:text-2xl font-bold text-white/90 font-mono tracking-[0.15em]">{{ $card->card_number }}</p>
                                        <p class="text-xs text-white/50 mt-1 font-medium tracking-wider uppercase">{{ $card->tier }}</p>
                                        <div class="mt-auto pt-3 flex justify-between text-[10px] text-white/40 font-mono">
                                            <span>{{ $card->issued_at?->format('M Y') }}</span>
                                            <span>{{ $card->expires_at?->format('M Y') }}</span>
                                        </div>
                                    @else
                                        <div class="flex-1 flex flex-col justify-center">
                                            <p class="text-[10px] tracking-[0.25em] uppercase text-white/50 font-mono mb-3">Redeemable Gift Card</p>
                                            <p class="text-2xl sm:text-3xl font-bold text-white/20 font-mono tracking-[0.12em] select-none">•••• &nbsp; •••• &nbsp; •••• &nbsp; ••••</p>
                                            <div class="mt-3 flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                                                <span class="text-[10px] tracking-wider uppercase text-white/40 font-mono">Awaiting Redemption</span>
                                            </div>
                                            <p class="mt-auto text-[10px] text-white/30 font-mono tracking-wider uppercase">Valid for one membership card</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Bottom accent --}}
                                <div class="h-1 w-full" style="background:linear-gradient(90deg, {{ $primaryColor }}, {{ $secondaryColor }});"></div>
                            </div>
                        </div>

                        {{-- Back --}}
                        <div class="card-face card-back">
                            <div class="h-full flex flex-col">
                                <div class="bg-black/20 px-5 sm:px-7 py-2.5 flex items-center justify-between">
                                    <span class="text-[10px] tracking-[0.25em] uppercase text-white/60 font-mono font-semibold">Gift Card</span>
                                    <span class="text-[10px] tracking-[0.2em] uppercase text-white/40 font-mono">{{ $celebrity->name }}</span>
                                </div>
                                <div class="flex-1 px-5 sm:px-7 py-4 flex flex-col justify-center gap-3">
                                    <div class="h-8 sm:h-10 rounded bg-white/10 w-full border border-white/10"></div>
                                    <div class="flex justify-center">
                                        <div class="w-36 h-20 sm:w-44 sm:h-24 rounded bg-gradient-to-br from-white/5 to-white/10 border border-white/10 flex items-center justify-center">
                                            <div class="text-[8px] sm:text-[10px] tracking-widest text-white/30 font-mono uppercase">{code}</div>
                                        </div>
                                    </div>
                                    <div class="text-[8px] sm:text-[9px] text-white/25 font-mono text-center leading-relaxed max-w-xs mx-auto">
                                        This card is non-transferable. Valid only for the named celebrity portal. Terms &amp; conditions apply.
                                    </div>
                                </div>
                                <div class="h-1 w-full" style="background:linear-gradient(90deg, {{ $primaryColor }}, {{ $secondaryColor }});"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-center mt-3 text-[11px] text-gray-400 flex items-center justify-center gap-1.5">
                    <svg class="w-3 h-3 text-indigo-400 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Click to flip · Drag to tilt
                </p>
            </div>

            @if (!$card)
                {{-- Redeem section --}}
                <div class="max-w-lg mx-auto">
                    @if ($cardFee > 0)
                        <div class="mb-4 rounded-xl border p-4 flex items-center gap-3" style="background:#fefce8;border-color:#fde68a;">
                            <div class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center" style="background:#f59e0b20;">
                                <svg class="w-4 h-4" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm text-gray-700"><span class="font-semibold">One-time fee: ${{ number_format($cardFee, 2) }}</span> &middot; Redeem your gift card to unlock exclusive perks.</p>
                        </div>
                    @endif

                    <div class="rounded-2xl border shadow-sm" style="background:white;border-color:#e5e7eb;">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-4 h-4" style="color:{{ $primaryColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                Redeem Your Card
                            </h2>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('celebrity.membership-card.order', ['celebrity' => $celebrity->slug]) }}" enctype="multipart/form-data" x-data="formValidation">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="tier" value="Choose your tier" />
                                    <p class="text-xs text-gray-400 mt-0.5 mb-1">Select the membership tier this card will represent.</p>
                                    <select name="tier" required
                                        x-on:change="validate('tier', $el.value, [validators.required])"
                                        x-bind:class="selectClass('tier')"
                                        class="form-input text-sm">
                                        <option value="">Select a tier...</option>
                                        @foreach (($celebrity->config['membership_tiers'] ?? []) as $tier)
                                            <option value="{{ $tier['name'] }}">{{ $tier['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <template x-if="invalid('tier')">
                                        <p x-text="errors.tier" class="text-red-500 text-xs mt-1"></p>
                                    </template>
                                </div>

                                @php
                                    $wallet = \App\Models\Wallet::findOrCreateForUser(auth()->user(), $celebrity);
                                @endphp
                                <x-payment-methods
                                    :methods="$celebrity->enabledPaymentMethods"
                                    :wallet="$wallet"
                                    label="Payment Method"
                                    :price="$cardFee"
                                    :celebrity="$celebrity"
                                />

                                <button type="submit"
                                    class="w-full text-white py-3 rounded-xl font-semibold text-sm shadow-sm hover:shadow-md transition-all"
                                    style="background:linear-gradient(135deg, {{ $primaryColor }}, {{ $secondaryColor }});">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $cardFee > 0 ? 'Redeem for $' . number_format($cardFee, 2) : 'Redeem Free' }}
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- Claimed card actions --}}
                <div class="max-w-lg mx-auto text-center">
                    <div class="rounded-2xl border shadow-sm p-6" style="background:white;border-color:#e5e7eb;">
                        <div class="flex items-center justify-center gap-2 mb-3">
                            <div class="w-2.5 h-2.5 rounded-full {{ $card->is_active ? 'bg-emerald-500' : 'bg-amber-500' }} animate-pulse"></div>
                            <span class="text-sm font-semibold {{ $card->is_active ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $card->is_active ? 'Card Redeemed — Ready to Use' : 'Card Pending Approval' }}
                            </span>
                        </div>
                        @if ($card->is_active)
                            <p class="text-sm text-gray-500 mb-4">Your gift card has been redeemed. Present it at events for VIP access.</p>
                            <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all"
                               style="background:linear-gradient(135deg, {{ $primaryColor }}, {{ $secondaryColor }});">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Go to Dashboard
                            </a>
                        @else
                            <p class="text-sm text-gray-500">Your card is awaiting approval. You'll be notified once it's ready.</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="max-w-lg mx-auto mt-8 text-center">
                <div class="rounded-xl border p-4" style="background:#f8fafc;border-color:#e2e8f0;">
                    <div class="flex items-center justify-center gap-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Exclusive perks
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Digital wallet
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Instant access
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scene {
            perspective: 1200px;
            width: 100%;
            aspect-ratio: 1.55 / 1;
            max-height: 360px;
            cursor: pointer;
        }
        .scene.is-spinning .card-3d {
            animation: flip 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .card-3d {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.1s ease-out;
            will-change: transform;
        }
        .card-face {
            position: absolute;
            inset: 0;
            border-radius: 16px;
            overflow: hidden;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .card-front {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #1e3a5f 100%);
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.4);
        }
        .card-back {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #1e3a5f 100%);
            border: 1px solid rgba(255,255,255,0.12);
            transform: rotateY(180deg);
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.4);
        }
        @keyframes flip {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(180deg); }
        }
        @media (max-width: 640px) {
            .scene { max-height: 240px; }
        }
    </style>

    <script>
        function card3d() {
            return {
                spinning: false,
                init() {
                    this.$refs.card3d.style.transform = 'rotateY(0deg) rotateX(0deg)';
                },
                onMove(e) {
                    if (this.spinning) return;
                    const el = this.$refs.card3d;
                    const rect = this.$el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    el.style.transform = 'rotateY(' + ((x - rect.width / 2) / (rect.width / 2) * 12) + 'deg) rotateX(' + (((rect.height / 2) - y) / (rect.height / 2) * 12) + 'deg)';
                },
                onLeave() {
                    if (this.spinning) return;
                    this.$refs.card3d.style.transform = 'rotateY(0deg) rotateX(0deg)';
                },
                onTouchMove(e) {
                    if (this.spinning) return;
                    const t = e.touches[0];
                    if (t) this.onMove({ clientX: t.clientX, clientY: t.clientY });
                },
                toggleSpin() {
                    if (this.spinning) return;
                    this.spinning = true;
                    const el = this.$refs.card3d;
                    el.style.transform = 'rotateY(180deg) rotateX(0deg)';
                    setTimeout(() => {
                        this.spinning = false;
                        el.style.transform = 'rotateY(0deg) rotateX(0deg)';
                    }, 1400);
                }
            };
        }
    </script>
</x-app-layout>