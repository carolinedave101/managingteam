<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Meet &amp; Greet <span class="gradient-text">Events</span></h1>
                <p class="text-gray-500 max-w-xl mx-auto">Get up close and personal. Attend exclusive events and create unforgettable memories.</p>
            </div>

            @if ($events->isEmpty())
                <div class="text-center py-20">
                    <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg">No upcoming events at this time.</p>
                    <p class="text-gray-400 text-sm mt-2">Check back soon for new dates!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($events as $event)
                        <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl">
                            <div class="h-40 bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 opacity-10">
                                    <div class="absolute top-4 left-4 w-20 h-20 rounded-full bg-pink-400"></div>
                                    <div class="absolute bottom-4 right-4 w-32 h-32 rounded-full bg-purple-400"></div>
                                </div>
                                <img src="/images/event.svg" alt="Event" class="h-24 w-auto opacity-60">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-pink-600 text-sm font-medium">{{ $event->date->format('F d, Y') }}</p>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-500 text-sm mb-4">{{ Str::limit($event->description, 120) }}</p>
                                <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $event->location }}</span>
                                </div>
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-2xl font-bold text-pink-600">${{ number_format($event->price, 2) }}</p>
                                    <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">Capacity: {{ $event->capacity }}</span>
                                </div>
                                @auth
                                    <button onclick="document.getElementById('ticket-{{ $event->id }}').classList.remove('hidden')" class="w-full bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 text-sm font-semibold transition">
                                        Get Tickets
                                    </button>
                                    <div id="ticket-{{ $event->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
                                        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl" onclick="event.stopPropagation()">
                                            <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                                            <p class="text-2xl font-bold text-pink-600 mb-6">${{ number_format($event->price, 2) }}</p>
                                            <form method="POST" action="{{ route('meet-greet.purchase') }}">
                                                @csrf
                                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                                <div class="mb-4">
                                                    <x-input-label for="quantity" value="Quantity" />
                                                    <input type="number" name="quantity" min="1" max="10" value="1" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" />
                                                </div>
                                                <div class="mb-4">
                                                    <x-input-label for="payment_method" value="Payment Method" />
                                                    <select name="payment_method" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                                        @foreach ($paymentMethods as $method)
                                                            <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-6">
                                                    <x-input-label for="payment_proof" value="Payment Proof" />
                                                    <input type="text" name="payment_proof" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Transaction ref or upload URL" />
                                                </div>
                                                <div class="flex gap-3">
                                                    <x-primary-button class="flex-1 justify-center">Purchase</x-primary-button>
                                                    <button type="button" onclick="this.closest('[id^=ticket-]').closest('[id^=ticket-]').classList.add('hidden')" class="px-5 py-2.5 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endauth
                                @guest
                                    <a href="{{ route('register') }}" class="block w-full bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 text-sm font-semibold text-center transition">Login to Purchase</a>
                                @endguest
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
