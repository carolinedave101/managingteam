<x-app-layout>
    <div class="hero-gradient">
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-24">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Welcome to the<br>
                        <span class="gradient-text">Jennie Kim</span><br>
                        Fan Community
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-xl">
                        Join the most exclusive fan community. Access premium content, attend meet & greet events, connect with fellow fans, and experience private meetups.
                    </p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <a href="{{ route('membership') }}" class="bg-pink-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-pink-700 shadow-lg shadow-pink-200 transition">
                            View Memberships
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="border-2 border-pink-600 text-pink-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-pink-50 transition">
                                Join Now
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('dashboard') }}" class="border-2 border-pink-600 text-pink-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-pink-50 transition">
                                My Dashboard
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="flex-1">
                    <img src="/images/hero.svg" alt="Jennie Kim" class="w-full max-w-md mx-auto animate-float">
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Everything for <span class="gradient-text">Real Fans</span></h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Premium features designed to bring you closer to the music, the moments, and the community.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Membership Tiers</h3>
                <p class="text-gray-500 leading-relaxed">Choose from Silver, Gold, Platinum, or Diamond tiers. Each level unlocks exclusive perks and privileges.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Meet &amp; Greet</h3>
                <p class="text-gray-500 leading-relaxed">Attend exclusive events. Get tickets to intimate meet & greet sessions with Jennie Kim herself.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Membership Card</h3>
                <p class="text-gray-500 leading-relaxed">Get your exclusive digital membership card. Show your card for VIP access at events and perks.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Private Messaging</h3>
                <p class="text-gray-500 leading-relaxed">Connect with other verified fans through our private messaging system. Build friendships that last.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Private Meetups</h3>
                <p class="text-gray-500 leading-relaxed">Request one-on-one private meetups with Jennie Kim for an unforgettable personal experience.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Exclusive Content</h3>
                <p class="text-gray-500 leading-relaxed">Premium members get access to exclusive content, early announcements, and special perks.</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-pink-50 to-purple-50 py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our <span class="gradient-text">Fans Say</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 text-yellow-400">★★★★★</div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">"This community is incredible! The meet & greet experience was unforgettable. Jennie is so warm and genuine."</p>
                    <p class="font-semibold text-gray-900">— Sarah M.</p>
                    <p class="text-sm text-gray-400">Platinum Member</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 text-yellow-400">★★★★★</div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">"Being part of this fan club has been amazing. The exclusive content and early access to events is worth every penny."</p>
                    <p class="font-semibold text-gray-900">— James K.</p>
                    <p class="text-sm text-gray-400">Diamond Member</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-6 h-6 text-yellow-400">★★★★★</div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">"The private messaging feature helped me connect with other fans who share the same passion. I've made lifelong friends here."</p>
                    <p class="font-semibold text-gray-900">— Mia L.</p>
                    <p class="text-sm text-gray-400">Gold Member</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-20 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Ready to <span class="gradient-text">Join?</span></h2>
        <p class="text-gray-500 mb-8 max-w-xl mx-auto">Start your journey as a verified fan. Choose a membership tier and unlock exclusive perks.</p>
        @guest
            <a href="{{ route('register') }}" class="bg-pink-600 text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-pink-700 shadow-lg shadow-pink-200 transition inline-block">
                Create Your Account
            </a>
        @endguest
        @auth
            <a href="{{ route('membership') }}" class="bg-pink-600 text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-pink-700 shadow-lg shadow-pink-200 transition inline-block">
                View Membership Plans
            </a>
        @endauth
    </div>
</x-app-layout>
