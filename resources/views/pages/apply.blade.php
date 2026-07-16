<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-white py-12">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Fan <span class="gradient-text">Application</span></h1>
                <p class="text-gray-500">Tell us about yourself and why you want to join this exclusive community.</p>
            </div>

            @if ($application)
                <div class="max-w-xl mx-auto">
                    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-2xl p-8 text-center shadow-sm">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h2 class="font-semibold text-xl text-yellow-800 mb-2">Application Status: <span class="capitalize">{{ $application->status }}</span></h2>
                        <p class="text-yellow-600">Submitted on {{ $application->created_at->format('F d, Y') }}</p>
                        @if ($application->status === 'pending')
                            <p class="text-gray-500 text-sm mt-4">Your application is being reviewed. We'll notify you once a decision is made.</p>
                        @elseif ($application->status === 'approved')
                            <p class="text-green-600 text-sm mt-4">Congratulations! Your application has been approved.</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="max-w-xl mx-auto">
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                        <form method="POST" action="{{ route('apply') }}" class="space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="bio" value="Your Bio" />
                                <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" required minlength="50" placeholder="Tell us about yourself...">{{ old('bio') }}</textarea>
                                <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="reason" value="Why do you want to join?" />
                                <textarea id="reason" name="reason" rows="4" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" required minlength="50" placeholder="Explain why you want to be part of this exclusive community...">{{ old('reason') }}</textarea>
                                <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="social_links" value="Social Links (optional)" />
                                <input id="social_links" name="social_links" type="text" value="{{ old('social_links') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Instagram, Twitter, etc." />
                                <x-input-error :messages="$errors->get('social_links')" class="mt-2" />
                            </div>
                            <x-primary-button class="w-full justify-center py-3">Submit Application</x-primary-button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
