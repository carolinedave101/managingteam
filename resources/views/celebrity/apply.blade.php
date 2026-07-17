<x-app-layout>
    <div class="mesh-gradient mesh-gradient-deep min-h-screen py-12 relative overflow-hidden">
        <div class="absolute top-20 left-10 w-64 h-64 bg-amber-200/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-48 h-48 bg-orange-200/20 rounded-full blur-3xl animate-blob-reverse pointer-events-none"></div>

        <div class="max-w-3xl mx-auto px-4">
            {{-- Header --}}
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Become a <span class="gradient-text gradient-text-gold">Verified Fan</span></h1>
                <p class="text-gray-500 max-w-lg mx-auto">Complete your application to join the {{ $celebrity->name }} fan community and unlock exclusive perks.</p>
            </div>

            {{-- How it works --}}
            @if (!$application || $application->status === 'rejected')
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-amber-100 shadow-md p-5 mb-8 glass-strong">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h2 class="text-base font-bold text-gray-900">How It Works</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                        <div class="p-3">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-2 text-amber-700 text-xs font-bold step-glow">1</div>
                            <p class="text-xs font-semibold text-gray-700">Fill in your details</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Tell us about yourself and why you want to join.</p>
                        </div>
                        <div class="p-3">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-2 text-amber-700 text-xs font-bold step-glow">2</div>
                            <p class="text-xs font-semibold text-gray-700">Pay the fee (if applicable)</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Choose your payment method and upload proof.</p>
                        </div>
                        <div class="p-3">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-2 text-amber-700 text-xs font-bold step-glow">3</div>
                            <p class="text-xs font-semibold text-gray-700">Get approved</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">The team reviews your application. You'll be notified!</p>
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>
            @endif

            @if ($application && $application->status === 'approved')
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-green-200 shadow-lg p-10 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-5 shadow-md">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2 gradient-text-gold">You're a Verified Fan! 🎉</h2>
                    <p class="text-green-600 mb-6">You have full access to the {{ $celebrity->name }} community. Explore memberships, events, and more!</p>
                    <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}"
                       class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Back to Dashboard
                    </a>
                </div>
            @elseif ($application && $application->status === 'pending')
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-yellow-200 shadow-lg p-10 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-100 to-amber-100 rounded-full flex items-center justify-center mx-auto mb-5 shadow-md">
                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2 gradient-text-gold">Application Pending</h2>
                    <p class="text-yellow-600 mb-2">Your application is being reviewed by the management team.</p>
                    <p class="text-sm text-yellow-500">You'll receive a notification as soon as a decision is made. This usually takes 1-3 business days.</p>
                </div>
            @elseif ($application && $application->status === 'rejected')
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-red-200 shadow-lg p-10 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-red-100 to-rose-100 rounded-full flex items-center justify-center mx-auto mb-5 shadow-md">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2 gradient-text-gold">Application Not Approved</h2>
                    <p class="text-red-600 mb-6">Your application wasn't approved at this time. You can re-apply with updated information.</p>
                    <a href="{{ route('celebrity.messages', ['celebrity' => $celebrity->slug]) }}"
                       class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Contact Team
                    </a>
                </div>
            @else
                {{-- Application form --}}
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-white/60 shadow-lg p-8 card-glow ring-glow-hover">
                    @php $fee = $celebrity->config['pricing']['fan_application_fee'] ?? 0; @endphp
                    @if ($fee > 0)
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 mb-6 flex items-start gap-4 banner-gradient-soft">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-amber-800">Application Fee: <span class="text-lg">${{ number_format($fee, 2) }}</span></p>
                                <p class="text-sm text-amber-700">This one-time fee is required to process your application. Select your payment method below.</p>
                                <p class="text-xs text-amber-600 mt-1">💡 <strong>Pro tip:</strong> Top up your wallet first for instant payment — no upload needed!</p>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('celebrity.apply.store', ['celebrity' => $celebrity->slug]) }}" enctype="multipart/form-data"
                           x-data="formValidation">
                        @csrf
                        <div class="space-y-6">
                            {{-- Bio --}}
                            <div>
                                <x-input-label for="bio" value="About You" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">Share a bit about who you are and your connection to {{ $celebrity->name }}. A thoughtful bio helps the team understand your passion.</p>
                                <textarea id="bio" name="bio" rows="4" required
                                    x-on:input.debounce.300ms="validate('bio', $el.value, [validators.required, validators.minLength(20)])"
                                    x-on:blur="validate('bio', $el.value, [validators.required, validators.minLength(20)])"
                                    x-bind:class="inputClass('bio')"
                                    class="form-input"
                                    placeholder="Hi! I'm a long-time fan. I first discovered {{ $celebrity->name }}'s music in...">{{ old('bio') }}</textarea>
                                <template x-if="invalid('bio')">
                                    <p x-text="errors.bio" class="text-red-500 text-xs mt-1"></p>
                                </template>
                                <template x-if="valid('bio')">
                                    <p class="text-green-600 text-xs mt-1">Great introduction!</p>
                                </template>
                            </div>

                            {{-- Reason --}}
                            <div>
                                <x-input-label for="reason" value="Why Do You Want to Join?" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">Tell us what excites you about being part of this exclusive community. Be specific about what experiences you're looking for.</p>
                                <textarea id="reason" name="reason" rows="3" required
                                    x-on:input.debounce.300ms="validate('reason', $el.value, [validators.required, validators.minLength(10)])"
                                    x-on:blur="validate('reason', $el.value, [validators.required, validators.minLength(10)])"
                                    x-bind:class="inputClass('reason')"
                                    class="form-input"
                                    placeholder="I want to be part of a community that shares the same passion and get access to exclusive content...">{{ old('reason') }}</textarea>
                                <template x-if="invalid('reason')">
                                    <p x-text="errors.reason" class="text-red-500 text-xs mt-1"></p>
                                </template>
                                <template x-if="valid('reason')">
                                    <p class="text-green-600 text-xs mt-1">We can't wait to hear more!</p>
                                </template>
                            </div>

                            {{-- Social links --}}
                            <div>
                                <x-input-label for="social_links" value="Social Media (optional)" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">Share your public social profiles so the team can learn more about you. Not required, but it helps!</p>
                                <input type="text" id="social_links" name="social_links" value="{{ old('social_links') }}"
                                    x-on:input.debounce.300ms="validate('social_links', $el.value, [])"
                                    x-on:blur="validate('social_links', $el.value, [])"
                                    x-bind:class="inputClass('social_links')"
                                    class="form-input"
                                    placeholder="e.g. @yourinstagram, @yourtwitter" />
                            </div>

                            {{-- Payment --}}
                            @if ($fee > 0)
                                @php
                                    $wallet = \App\Models\Wallet::findOrCreateForUser(auth()->user(), $celebrity);
                                @endphp
                                <x-payment-methods
                                    :methods="$celebrity->enabledPaymentMethods"
                                    :wallet="$wallet"
                                    :celebrity="$celebrity"
                                    label="Payment Method"
                                    amountLabel="Application Fee: ${{ number_format($fee, 2) }}"
                                    :price="$fee"
                                />
                            @endif

                            {{-- Submit --}}
                            <div class="pt-2">
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-amber-500 to-orange-600 text-white py-3.5 rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 animate-shine cta-pulse">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $fee > 0 ? 'Pay & Submit Application' : 'Submit Application' }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
