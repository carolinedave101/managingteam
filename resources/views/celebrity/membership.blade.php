<x-app-layout>
    @php
        $theme = $celebrity->config['theme'] ?? [];
        $primaryColor = $theme['primary_color'] ?? '#ec4899';
    @endphp
    <div class="mesh-gradient-deep min-h-screen py-12 relative overflow-hidden">
        {{-- Decorative background elements --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-gradient-to-br from-pink-200/30 to-transparent opacity-60 animate-blob-reverse"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-gradient-to-tr from-violet-200/30 to-transparent opacity-50 animate-float"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative">
            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Membership <span class="gradient-text">Plans</span></h1>
                <p class="text-gray-500 max-w-xl mx-auto">Choose the tier that fits your passion. Each level brings you closer to {{ $celebrity->name }}.</p>
            </div>

            {{-- How it works --}}
            <div class="max-w-3xl mx-auto mb-10">
                <div class="glass-strong rounded-2xl p-5 shadow-md">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h2 class="text-base font-bold text-gray-900">How to Subscribe</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-center">
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-1.5 text-pink-700 text-[11px] font-bold">1</div>
                            <p class="text-xs font-semibold text-gray-700">Choose a tier</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Browse plans and pick your favorite.</p>
                        </div>
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-1.5 text-pink-700 text-[11px] font-bold">2</div>
                            <p class="text-xs font-semibold text-gray-700">Click Subscribe</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Open the payment modal for your chosen tier.</p>
                        </div>
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-1.5 text-pink-700 text-[11px] font-bold">3</div>
                            <p class="text-xs font-semibold text-gray-700">Pay</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Select method, upload proof or use wallet.</p>
                        </div>
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-1.5 text-pink-700 text-[11px] font-bold">4</div>
                            <p class="text-xs font-semibold text-gray-700">Enjoy!</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Unlock exclusive perks immediately.</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($activeMembership)
                <div class="max-w-2xl mx-auto mb-10">
                    <div class="banner-gradient rounded-2xl p-6 shadow-md">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="font-bold text-lg text-white/90">Active {{ ucfirst($activeMembership->tier) }} Membership</h2>
                                        <p class="text-white/70 text-sm mt-0.5">Member since {{ $activeMembership->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="animate-pulse-glow px-3 py-1 bg-white/20 text-white rounded-full text-xs font-bold">Active</span>
                                </div>
                                <p class="text-white/70 mt-3 text-sm">You're enjoying all the benefits of the {{ $activeMembership->tier }} plan. Thank you for being a valued member!</p>
                                <form method="POST" action="{{ route('celebrity.membership.cancel', ['celebrity' => $celebrity->slug]) }}" class="mt-3">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel your membership? This action cannot be undone.')"
                                            class="text-red-200 hover:text-white text-sm font-medium flex items-center gap-1.5 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Cancel Membership
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tiers grid --}}
            <div class="flex flex-wrap justify-center gap-6 [&>*]:grow [&>*]:basis-60 [&>*]:max-w-sm">
                @foreach ($tiers as $tier)
                    <div class="tier-card card-hover ring-glow-hover bg-white rounded-2xl border-2 shadow-sm
                        {{ $activeMembership?->tier === $tier['name']
                            ? 'border-pink-500 ring-2 ring-pink-500'
                            : ($loop->index === 1 ? 'tier-card featured' : 'border-gray-100') }}">
                        @if ($activeMembership?->tier === $tier['name'])
                            <div class="bg-gradient-to-r from-pink-500 to-rose-500 text-white text-center text-xs font-bold py-1.5 tracking-wider uppercase">Your Current Plan</div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ $tier['name'] }}</h3>
                            <div class="mt-3 mb-4">
                                <span class="price-glow text-4xl font-bold">${{ number_format($tier['price'], 0) }}</span>
                                <span class="text-sm text-gray-400">/month</span>
                            </div>
                            <ul class="space-y-3 mb-6">
                                @foreach ($tier['benefits'] as $benefit)
                                    <li class="flex items-start text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $benefit }}
                                    </li>
                                @endforeach
                            </ul>
                            @auth
                                @if (!$activeMembership)
                                    <button onclick="document.getElementById('subscribe-{{ Str::slug($tier['name']) }}').classList.add('modal-open')"
                                            class="animate-shine cta-pulse w-full bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 text-sm font-semibold transition shadow-md hover:shadow-lg">
                                        Subscribe Now
                                    </button>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('register') }}" class="animate-shine cta-pulse block w-full bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 text-sm font-semibold text-center transition shadow-md">Join to Subscribe</a>
                            @endguest
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Subscribe modals (outside tier cards to avoid overflow clipping) --}}
            @auth
                @if (!$activeMembership)
                    @foreach ($tiers as $tier)
                        <div id="subscribe-{{ Str::slug($tier['name']) }}" class="modal-overlay fixed inset-0 bg-black/60 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target===this)this.classList.remove('modal-open')">
                            <div class="modal-content" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold">Subscribe to {{ $tier['name'] }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">You're about to subscribe to the {{ $tier['name'] }} plan.</p>
                                    </div>
                                    <button onclick="document.getElementById('subscribe-{{ Str::slug($tier['name']) }}').classList.remove('modal-open')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                <div class="banner-gradient-soft rounded-xl p-4 mb-6 flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-700">Total</span>
                                    <span class="price-gold text-2xl font-bold">${{ number_format($tier['price'], 2) }}</span>
                                </div>

                                <form method="POST" action="{{ route('celebrity.membership.subscribe', ['celebrity' => $celebrity->slug]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="tier" value="{{ $tier['name'] }}">
                                    <input type="hidden" name="price" value="{{ $tier['price'] }}">
                                    @php
                                        $wallet = \App\Models\Wallet::findOrCreateForUser(auth()->user(), $celebrity);
                                    @endphp
                                    <x-payment-methods
                                        :methods="$paymentMethods"
                                        :wallet="$wallet"
                                        label="Payment Method"
                                        amountLabel="Plan: {{ $tier['name'] }} — ${{ number_format($tier['price'], 2) }}/mo"
                                        :price="$tier['price']"
                                    />
                                    <div class="flex gap-3 mt-6">
                                        <button type="submit" class="animate-shine cta-pulse flex-1 bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 font-bold text-sm transition shadow-md">
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Complete Payment
                                            </span>
                                        </button>
                                        <button type="button" onclick="document.getElementById('subscribe-{{ Str::slug($tier['name']) }}').classList.remove('modal-open')"
                                                class="px-5 py-3 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium text-sm">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endauth

            {{-- FAQ-style tips --}}
            <div class="max-w-2xl mx-auto mt-12">
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-gray-100 shadow-md p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">💡 Membership Tips</h3>
                    <ul class="space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-pink-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span><strong class="text-gray-900">Wallet is fastest:</strong> Top up your wallet first, then pay instantly with no upload needed.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-pink-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span><strong class="text-gray-900">Upgrade anytime:</strong> You can switch to a higher tier at any time — just subscribe to the new plan.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-pink-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span><strong class="text-gray-900">Need help?</strong> Send a message to the team via your dashboard — we're here for you.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
