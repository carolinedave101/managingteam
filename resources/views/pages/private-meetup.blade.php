<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-white py-12">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Book a Private <span class="gradient-text">Meetup</span></h1>
                <p class="text-gray-500 max-w-lg mx-auto">Request a one-on-one private session with Jennie Kim. Choose your preferred duration and settings.</p>
            </div>

            <div class="max-w-xl mx-auto">
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                    <form method="POST" action="{{ route('private-meetup.store') }}" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="title" value="Meetup Title" />
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="e.g., Video Call Session" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="description" value="Description (optional)" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="What would you like to discuss?">{{ old('description') }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="date" value="Date & Time" />
                                <input id="date" name="date" type="datetime-local" value="{{ old('date') }}" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="duration" value="Duration" />
                                <select id="duration" name="duration" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                    <option value="30">30 min — $10.00</option>
                                    <option value="60" selected>60 min — $25.00</option>
                                    <option value="90">90 min — $50.00</option>
                                    <option value="120">120 min — $100.00</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <x-input-label for="location" value="Location (optional)" />
                            <input id="location" name="location" type="text" value="{{ old('location') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Zoom, in-person address, etc." />
                        </div>
                        <div>
                            <x-input-label for="notes" value="Notes (optional)" />
                            <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Any special requests...">{{ old('notes') }}</textarea>
                        </div>
                        <hr class="border-gray-100">
                        <div>
                            <x-input-label for="payment_method" value="Payment Method" />
                            <select id="payment_method" name="payment_method" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="payment_proof" value="Payment Proof" />
                            <input id="payment_proof" name="payment_proof" type="text" required class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Transaction reference or upload URL" />
                        </div>
                        <x-primary-button class="w-full justify-center py-3">Book Meetup</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
