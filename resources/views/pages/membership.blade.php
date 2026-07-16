<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Membership <span class="gradient-text">Plans</span></h1>
                <p class="text-gray-500 max-w-xl mx-auto">Choose the tier that fits your passion. Each level brings you closer to Jennie Kim.</p>
            </div>

            @if ($activeMembership)
                <div class="max-w-2xl mx-auto mb-12">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="font-semibold text-lg text-green-800">Active {{ ucfirst($activeMembership->tier) }} Membership</h2>
                                <p class="text-green-600 text-sm mt-1">Member since {{ $activeMembership->created_at->format('M d, Y') }}</p>
                                <form method="POST" action="{{ route('membership.cancel') }}" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1">
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($tiers as $tier)
                    <div class="card-hover bg-white rounded-2xl border-2 overflow-hidden shadow-sm hover:shadow-xl {{ $activeMembership?->tier === $tier['id'] ? 'border-pink-500 ring-2 ring-pink-500' : 'border-gray-100' }}">
                        @if ($tier['id'] === 'diamond')
                            <div class="bg-gradient-to-r from-pink-500 to-purple-600 text-white text-center text-xs font-bold py-2 uppercase tracking-wider">Most Popular</div>
                        @endif
                        <div class="p-6">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 {{ $tier['id'] === 'diamond' ? 'bg-purple-100' : ($tier['id'] === 'platinum' ? 'bg-pink-100' : ($tier['id'] === 'gold' ? 'bg-yellow-100' : 'bg-gray-100')) }}">
                                @if ($tier['id'] === 'diamond')
                                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                @elseif ($tier['id'] === 'platinum')
                                    <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                @elseif ($tier['id'] === 'gold')
                                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                @else
                                    <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $tier['name'] }}</h3>
                            <p class="text-3xl font-bold text-pink-600 mt-2">${{ number_format($tier['price'] / 100, 2) }}</p>
                            <p class="text-sm text-gray-400 mb-4">One-time payment</p>
                            <ul class="space-y-3">
                                @foreach ($tier['features'] as $feature)
                                    <li class="flex items-start text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                            @auth
                                @if (!$activeMembership)
                                    <button onclick="document.getElementById('subscribe-{{ $tier['id'] }}').classList.remove('hidden')" class="mt-6 w-full bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 text-sm font-semibold transition">
                                        Subscribe Now
                                    </button>
                                    <div id="subscribe-{{ $tier['id'] }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
                                        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl" onclick="event.stopPropagation()">
                                            <h3 class="text-xl font-bold mb-2">Subscribe to {{ $tier['name'] }}</h3>
                                            <p class="text-2xl font-bold text-pink-600 mb-6">${{ number_format($tier['price'] / 100, 2) }}</p>
                                            <form method="POST" action="{{ route('membership.subscribe') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="tier" value="{{ $tier['id'] }}">
                                                <input type="hidden" name="price" value="{{ $tier['price'] }}">
                                                <div class="mb-5">
                                                    <x-input-label for="payment_method" value="Payment Method" />
                                                    <select name="payment_method" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                                        @foreach ($paymentMethods ?? [] as $method)
                                                            <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-6">
                                                    <x-input-label for="payment_proof" value="Payment Proof" />
                                                    <input type="text" name="payment_proof" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Transaction ref or upload URL" />
                                                </div>
                                                <div class="flex gap-3">
                                                    <x-primary-button class="flex-1 justify-center">Submit Payment</x-primary-button>
                                                    <button type="button" onclick="this.closest('[id^=subscribe-]').classList.add('hidden')" class="px-5 py-2.5 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('register') }}" class="mt-6 block w-full bg-pink-600 text-white py-3 rounded-xl hover:bg-pink-700 text-sm font-semibold text-center transition">Join to Subscribe</a>
                            @endguest
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
