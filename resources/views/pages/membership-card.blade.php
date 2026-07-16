<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-white py-12">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Membership <span class="gradient-text">Card</span></h1>
                <p class="text-gray-500">Your exclusive digital membership card for VIP access.</p>
            </div>

            @if ($card)
                <div class="max-w-lg mx-auto">
                    <div class="bg-gradient-to-br from-pink-500 via-pink-600 to-purple-700 rounded-2xl p-8 text-white shadow-xl shadow-pink-200">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <p class="text-xs uppercase tracking-widest opacity-70">Digital Membership Card</p>
                                <p class="text-lg font-mono mt-2 tracking-wider opacity-90">{{ $card->card_number }}</p>
                            </div>
                            <span class="text-xs uppercase tracking-wider bg-white/20 px-3 py-1 rounded-full">{{ $card->tier }}</span>
                        </div>
                        <div class="border-t border-white/20 pt-6">
                            <p class="text-xl font-bold">{{ auth()->user()->name }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="w-2 h-2 rounded-full {{ $card->is_active ? 'bg-green-400' : 'bg-yellow-400' }}"></span>
                                <p class="text-sm opacity-80">{{ $card->is_active ? 'Active' : 'Pending Approval' }}</p>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-between text-xs opacity-50">
                            <span>JENNIE KIM FAN CLUB</span>
                            <span>{{ now()->format('Y') }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="max-w-lg mx-auto">
                    <div class="text-center mb-8">
                        <img src="/images/member-card.svg" alt="Membership Card" class="w-48 mx-auto mb-6 opacity-60">
                        <p class="text-gray-600">You don't have a membership card yet. Order one below to unlock VIP perks.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                        <form method="POST" action="{{ route('membership-card.order') }}" class="space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="tier" value="Card Tier" />
                                <select name="tier" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                    <option value="bronze">Bronze</option>
                                    <option value="silver">Silver</option>
                                    <option value="gold">Gold</option>
                                    <option value="platinum">Platinum</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="payment_method" value="Payment Method" />
                                <select name="payment_method" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                    @foreach ($paymentMethods as $method)
                                        <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="payment_proof" value="Payment Proof" />
                                <input type="text" name="payment_proof" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Transaction reference or upload URL" />
                            </div>
                            <x-primary-button class="w-full justify-center py-3">Order Card</x-primary-button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
