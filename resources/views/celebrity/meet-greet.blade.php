<x-app-layout>
    <div class="mesh-gradient-deep min-h-screen py-12 relative overflow-hidden">
        {{-- Decorative background elements --}}
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300/20 rounded-full blur-3xl animate-blob-reverse pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-violet-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Meet &amp; <span class="gradient-text">Greet</span> <span class="gradient-text-gold">Events</span></h1>
                <p class="text-gray-500 max-w-xl mx-auto">Get up close and personal with {{ $celebrity->name }} at exclusive events.</p>
            </div>

            {{-- How it works --}}
            <div class="max-w-3xl mx-auto mb-10">
                <div class="glass-strong bg-white/90 backdrop-blur-sm rounded-2xl border border-purple-100 shadow-md p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h2 class="text-base font-bold text-gray-900">How to Get Tickets</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-center">
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-1.5 text-purple-700 text-[11px] font-bold">1</div>
                            <p class="text-xs font-semibold text-gray-700">Browse events</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Pick an event you want to attend.</p>
                        </div>
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-1.5 text-purple-700 text-[11px] font-bold">2</div>
                            <p class="text-xs font-semibold text-gray-700">Choose quantity</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">How many tickets do you need?</p>
                        </div>
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-1.5 text-purple-700 text-[11px] font-bold">3</div>
                            <p class="text-xs font-semibold text-gray-700">Pay</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Select method, upload proof or use wallet.</p>
                        </div>
                        <div class="p-2">
                            <div class="step-glow w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-1.5 text-purple-700 text-[11px] font-bold">4</div>
                            <p class="text-xs font-semibold text-gray-700">Get excited!</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Your tickets will be confirmed by the team.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            @if (count($events))
                <div class="flex flex-wrap justify-center gap-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                    @foreach ($events as $event)
                        <div class="card-glow ring-glow-hover bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl overflow-hidden transition-all duration-300">
                            @if ($event->image_url)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-sm text-purple-600 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $event->date->format('F j, Y') }}
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ $event->description }}</p>
                                <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                                    <div>
                                        <span class="text-sm text-gray-400">{{ $event->location }}</span>
                                        <p class="text-lg font-bold text-pink-600 price-glow">${{ number_format($event->price, 2) }}</p>
                                    </div>
                                    @auth
                                        <button onclick="document.getElementById('purchase-{{ $event->id }}').classList.add('modal-open')"
                                                class="animate-shine cta-pulse bg-pink-600 text-white px-5 py-2.5 rounded-xl hover:bg-pink-700 text-sm font-semibold transition shadow-md">
                                            Get Ticket
                                        </button>
                                    @else
                                        <a href="{{ route('register') }}" class="animate-shine bg-pink-600 text-white px-5 py-2.5 rounded-xl hover:bg-pink-700 text-sm font-semibold transition shadow-md">
                                            Join to Buy
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Purchase modals (outside card grid to avoid overflow clipping) --}}
                @auth
                    @foreach ($events as $event)
                        <div id="purchase-{{ $event->id }}" class="modal-overlay fixed inset-0 bg-black/60 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target===this)this.classList.remove('modal-open')">
                            <div class="modal-content bg-white rounded-2xl p-8 max-w-lg w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold">Get Tickets</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $event->title }} · {{ $event->date->format('F j, Y') }}</p>
                                    </div>
                                    <button onclick="document.getElementById('purchase-{{ $event->id }}').classList.remove('modal-open')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                <div class="banner-gradient-soft rounded-xl p-4 mb-6 flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-700">Price per ticket</span>
                                    <span class="text-2xl font-bold text-pink-600 price-glow">${{ number_format($event->price, 2) }}</span>
                                </div>

                                <form method="POST" action="{{ route('celebrity.meet-greet.purchase', ['celebrity' => $celebrity->slug]) }}" enctype="multipart/form-data"
                                      x-data="formValidation">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <div class="mb-5">
                                        <x-input-label for="quantity-{{ $event->id }}" value="Quantity" />
                                        <p class="text-xs text-gray-400 mt-0.5 mb-1">How many tickets would you like? You can purchase up to 10 tickets per order.</p>
                                        <input type="number" id="quantity-{{ $event->id }}" name="quantity" min="1" max="10" value="1" required
                                               x-on:input.debounce.300ms="validate('quantity', $el.value, [validators.required, validators.numeric, validators.min(1), validators.max(10)])"
                                               x-on:blur="validate('quantity', $el.value, [validators.required, validators.numeric, validators.min(1), validators.max(10)])"
                                               x-bind:class="inputClass('quantity')"
                                               class="form-input" />
                                        <template x-if="invalid('quantity')">
                                            <p x-text="errors.quantity" class="text-red-500 text-xs mt-1"></p>
                                        </template>
                                        <template x-if="valid('quantity')">
                                            <p class="text-green-600 text-xs mt-1">Quantity set!</p>
                                        </template>
                                    </div>
                                    @php
                                        // wallet resolved in controller
                                    @endphp
                                    <x-payment-methods
                                        :methods="$paymentMethods"
                                        :wallet="$wallet"
                                        :celebrity="$celebrity"
                                        label="Payment Method"
                                        amountLabel="${{ number_format($event->price, 2) }} per ticket"
                                        :price="$event->price"
                                    />
                                    <div class="flex gap-3 mt-6">
                                        <button type="submit" class="flex-1 bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 font-bold text-sm transition shadow-md">
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                                Purchase Tickets
                                            </span>
                                        </button>
                                        <button type="button" onclick="document.getElementById('purchase-{{ $event->id }}').classList.remove('modal-open')"
                                                class="px-5 py-3 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium text-sm">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endauth
            @else
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700">No events scheduled yet</h3>
                    <p class="text-gray-400 mt-2">Check back soon for upcoming events. Follow {{ $celebrity->name }} on social media for announcements!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
