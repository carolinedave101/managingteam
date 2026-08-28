<x-app-layout>
    <div class="mesh-gradient-deep min-h-screen py-12 relative overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-teal-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl animate-blob-reverse"></div>
        <div class="max-w-4xl mx-auto px-4 relative">
            {{-- Header --}}
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a3 3 0 003-3V8a3 3 0 00-3-3H5a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Private <span class="gradient-text-gold">Meetup</span></h1>
                <p class="text-gray-500 max-w-lg mx-auto">Request a private one-on-one meetup with {{ $celebrity->name }} for an unforgettable experience.</p>
            </div>

            {{-- How it works --}}
            <div class="max-w-3xl mx-auto mb-8">
                <div class="glass-strong rounded-2xl border border-teal-100 shadow-md p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h2 class="text-base font-bold text-gray-900">How to Book a Private Meetup</h2>
                    </div>
                    @php
                        $meetupMode = $celebrity->config['pricing']['private_meetup_mode'] ?? 'duration';
                        $fixedPrice = $celebrity->config['pricing']['private_meetup_fixed'] ?? 0;
                        $stepItems = $meetupMode === 'fixed'
                            ? [
                                ['label' => 'Fill details', 'hint' => 'Title, description, date & location.'],
                                ['label' => 'Pay', 'hint' => 'One-time price, select method or use wallet.'],
                                ['label' => 'Confirmation', 'hint' => 'Team reviews and confirms your meetup.'],
                            ]
                            : [
                                ['label' => 'Fill details', 'hint' => 'Title, description, date & location.'],
                                ['label' => 'Choose duration', 'hint' => 'Pick 30, 60, 90, or 120 minutes.'],
                                ['label' => 'Pay', 'hint' => 'Select method, upload proof or use wallet.'],
                                ['label' => 'Confirmation', 'hint' => 'Team reviews and confirms your meetup.'],
                            ];
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-{{ count($stepItems) }} gap-3 text-center">
                        @foreach ($stepItems as $index => $step)
                            <div class="p-2">
                                <div class="step-glow w-7 h-7 rounded-full bg-teal-100 flex items-center justify-center mx-auto mb-1.5 text-teal-700 text-[11px] font-bold">{{ $index + 1 }}</div>
                                <p class="text-xs font-semibold text-gray-700">{{ $step['label'] }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ $step['hint'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
                {{-- Left: Pricing + Info --}}
                <div class="space-y-6">
                    @php
                        $meetupPricing = $celebrity->config['pricing']['private_meetup'] ?? [];
                        $minMeetupPrice = $meetupMode === 'fixed'
                            ? (float) $fixedPrice
                            : (collect($meetupPricing)->min('price') ?? 0);
                    @endphp
                    @if ($meetupMode === 'fixed' ? (float) $fixedPrice > 0 : count($meetupPricing))
                        <div class="card-glow ring-glow-hover bg-white/90 backdrop-blur-sm rounded-2xl border border-teal-100 shadow-md p-6 depth-card" x-data="sheenCard">
                            <div class="card-sheen" aria-hidden="true"></div>
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <h3 class="text-base font-bold text-gray-900">Pricing</h3>
                            </div>
                            @if ($meetupMode === 'fixed')
                                <div class="card-glow ring-glow-hover flex items-center justify-between p-3 rounded-xl bg-teal-50/50 border border-teal-100/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center text-teal-700 text-xs font-bold">∞</div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">Any duration</p>
                                            <p class="text-xs text-gray-400">One-time fixed price — length agreed with the team</p>
                                        </div>
                                    </div>
                                    <span class="price-glow price-gold text-lg font-bold text-teal-600">${{ number_format($fixedPrice, 2) }}</span>
                                </div>
                            @else
                                <div class="space-y-2">
                                    @foreach ($meetupPricing as $option)
                                        <div class="card-glow ring-glow-hover flex items-center justify-between p-3 rounded-xl bg-teal-50/50 border border-teal-100/50">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center text-teal-700 text-xs font-bold">{{ $option['duration'] }}</div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-700">{{ $option['duration'] }} minutes</p>
                                                    <p class="text-xs text-gray-400">Private session</p>
                                                </div>
                                            </div>
                                            <span class="price-glow price-gold text-lg font-bold text-teal-600">${{ number_format($option['price'], 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <p class="text-xs text-gray-400 mt-4">💡 All prices are one-time payments. Duration starts when the meetup begins.</p>
                        </div>
                    @endif

                    <div class="banner-gradient rounded-2xl p-6 text-white shadow-lg">
                        <div class="flex items-center gap-3 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="font-bold">What happens next?</p>
                        </div>
                        <ol class="text-sm text-white/80 space-y-2 ml-5 list-decimal">
                            <li>You submit your request with payment.</li>
                            <li>The team reviews your request within 1-2 business days.</li>
                            <li>You'll receive a confirmation with details.</li>
                            <li>Meetup happens at the scheduled time!</li>
                        </ol>
                    </div>
                </div>

                {{-- Right: Form --}}
                <div class="card-glow ring-glow-hover bg-white/90 backdrop-blur-sm rounded-2xl border border-white/60 shadow-lg p-8 depth-card" x-data="sheenCard">
                    <div class="card-sheen" aria-hidden="true"></div>
                    <form method="POST" action="{{ route('celebrity.private-meetup.store', ['celebrity' => $celebrity->slug]) }}" enctype="multipart/form-data"
                          x-data="formValidation">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="title" value="Meetup Title" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">Give your meetup a name so the team knows what it's about.</p>
                                <input type="text" id="title" name="title" required
                                    x-on:input.debounce.300ms="validate('title', $el.value, [validators.required])"
                                    x-on:blur="validate('title', $el.value, [validators.required])"
                                    x-bind:class="inputClass('title')"
                                    class="form-input"
                                    placeholder="e.g., Birthday Meetup, Fan Chat" value="{{ old('title') }}" />
                                <template x-if="invalid('title')">
                                    <p x-text="errors.title" class="text-red-500 text-xs mt-1"></p>
                                </template>
                                <template x-if="valid('title')">
                                    <p class="text-green-600 text-xs mt-1">Great name!</p>
                                </template>
                            </div>

                            <div>
                                <x-input-label for="description" value="Description (optional)" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">What would you like to do during the meetup? Share your ideas so we can plan the perfect experience.</p>
                                <textarea id="description" name="description" rows="3"
                                    x-on:input.debounce.300ms="validate('description', $el.value, [])"
                                    x-on:blur="validate('description', $el.value, [])"
                                    x-bind:class="inputClass('description')"
                                    class="form-input"
                                    placeholder="Tell us more about your request and what you're looking forward to...">{{ old('description') }}</textarea>
                            </div>

                            <div class="{{ $meetupMode === 'fixed' ? '' : 'grid grid-cols-2 gap-4' }}">
                                <div class="{{ $meetupMode === 'fixed' ? 'sm:col-span-2' : '' }}">
                                    <x-input-label for="date" value="Preferred Date &amp; Time" />
                                    <p class="text-xs text-gray-400 mt-0.5 mb-1">Pick your ideal date and time. Make sure it's at least 48 hours from now.</p>
                                    <input type="datetime-local" id="date" name="date" required
                                        x-on:change="validate('date', $el.value, [validators.required])"
                                        x-on:blur="validate('date', $el.value, [validators.required])"
                                        x-bind:class="inputClass('date')"
                                        class="form-input" value="{{ old('date') }}" />
                                    <template x-if="invalid('date')">
                                        <p x-text="errors.date" class="text-red-500 text-xs mt-1"></p>
                                    </template>
                                    <template x-if="valid('date')">
                                        <p class="text-green-600 text-xs mt-1">Perfect time!</p>
                                    </template>
                                </div>
                                @if ($meetupMode === 'duration')
                                <div>
                                    <x-input-label for="duration" value="Duration" />
                                    <p class="text-xs text-gray-400 mt-0.5 mb-1">How long would you like the meetup to last?</p>
                                    <select id="duration" name="duration" required
                                        x-on:change="validate('duration', $el.value, [validators.required])"
                                        x-bind:class="selectClass('duration')"
                                        class="form-input">
                                        <option value="">Select duration...</option>
                                        @foreach ($meetupPricing as $option)
                                            <option value="{{ $option['duration'] }}">{{ $option['duration'] }} min — ${{ number_format($option['price'], 2) }}</option>
                                        @endforeach
                                    </select>
                                    <template x-if="invalid('duration')">
                                        <p x-text="errors.duration" class="text-red-500 text-xs mt-1"></p>
                                    </template>
                                </div>
                                @endif
                            </div>

                            <div>
                                <x-input-label for="location" value="Location (optional)" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">Where would you like the meetup to take place? You can also specify "Online" for virtual meetups.</p>
                                <input type="text" id="location" name="location"
                                    x-on:input.debounce.300ms="validate('location', $el.value, [])"
                                    x-on:blur="validate('location', $el.value, [])"
                                    x-bind:class="inputClass('location')"
                                    class="form-input"
                                    placeholder="e.g., Seoul, New York, or Online" value="{{ old('location') }}" />
                            </div>

                            <div>
                                <x-input-label for="notes" value="Additional Notes (optional)" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">Anything else the team should know to make this meetup special? Dietary preferences, accessibility needs, special requests — let us know!</p>
                                <textarea id="notes" name="notes" rows="2"
                                    x-on:input.debounce.300ms="validate('notes', $el.value, [])"
                                    x-on:blur="validate('notes', $el.value, [])"
                                    x-bind:class="inputClass('notes')"
                                    class="form-input">{{ old('notes') }}</textarea>
                            </div>

                            @php
                                // wallet resolved in controller
                            @endphp
                            <x-payment-methods
                                :methods="$paymentMethods"
                                :wallet="$wallet"
                                :celebrity="$celebrity"
                                label="Payment Method"
                                amountLabel="{{ $meetupMode === 'fixed' ? 'One-time price of $' . number_format($fixedPrice, 2) : 'Price depends on selected duration' }}"
                                :price="$minMeetupPrice"
                            />

                            <button type="submit"
                                    class="animate-shine w-full bg-gradient-to-r from-teal-500 to-cyan-600 text-white py-3.5 rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Request Private Meetup
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
