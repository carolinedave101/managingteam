<x-app-layout>
    @php
        $c = $celebrity->config;
        $content = $c['site_content'] ?? [];
        $features = $c['features'] ?? [];
        $tiers = $c['membership_tiers'] ?? [];
        $payments = $celebrity->enabledPaymentMethods;
        $theme = $c['theme'] ?? [];
        $cat = $celebrity->category;

        $catDefaults = [
            'movie_star' => [
                'section_heading' => 'Hollywood & Red Carpet',
                'section_subheading' => 'Premium access',
                'features_heading' => 'Everything for <span class="gradient-text-gold">True Fans</span>',
                'features_subheading' => 'Red carpet access, exclusive premieres, and behind-the-scenes content.',
                'pricing_heading' => 'Your <span class="gradient-text-gold">VIP</span> Experience',
                'pricing_subheading' => 'Choose the access level that matches your passion for the spotlight.',
                'events_heading' => 'Upcoming <span class="gradient-text-gold">Premieres</span>',
                'events_subheading' => 'Be there for exclusive screenings and red carpet moments.',
                'cta_heading' => 'Ready to Step Into the Spotlight?',
                'cta_subheading' => 'Join ' . $celebrity->name . '\'s inner circle. Unlock VIP access to premieres and exclusive content.',
                'stats' => [
                    ['value' => '50+', 'label' => 'Box Office Hits'],
                    ['value' => '200+', 'label' => 'Award Nominations'],
                    ['value' => '15', 'label' => 'Years in Film'],
                    ['value' => '100M+', 'label' => 'Global Fans'],
                ],
                'about_title' => 'From the Screen to Your World',
                'about_body' => '<p>' . $celebrity->name . ' has captivated audiences worldwide with unforgettable performances on the big screen. This is your exclusive backstage pass — the official fan community where you get closer than ever before.</p><p>Join fellow fans, access premium content, and be part of a community that celebrates the magic of cinema.</p>',
                'features' => [
                    'membership' => ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'VIP Membership', 'Unlock exclusive tiers with red carpet invites, signed merch, and priority access to all events.'],
                    'meet_greet' => ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Meet & Greet', 'Attend exclusive screenings and red carpet events. Get up close and personal with the star.'],
                    'membership_card' => ['M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'VIP Card', 'Your digital backstage pass for priority access at premieres, events, and exclusive fan gatherings.'],
                    'private_meetup' => ['M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Private Meetup', 'Request an intimate one-on-one with the star. A personal experience you\'ll never forget.'],
                    'messaging' => ['M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'Fan Mail', 'Send messages directly to the management team and stay connected with the community.'],
                    'fan_applications' => ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Fan Verification', 'Apply to become a verified fan and unlock exclusive Hollywood-level perks.'],
                ],
            ],
            'country_singer' => [
                'section_heading' => 'Southern Roots & Country Vibes',
                'section_subheading' => 'Family, music, and good times',
                'features_heading' => 'Everything for <span class="gradient-text-gold">True Country Fans</span>',
                'features_subheading' => 'Backstage passes, exclusive acoustic sets, and the best fan community in country music.',
                'pricing_heading' => 'Your <span class="gradient-text-gold">Front Row</span> Pass',
                'pricing_subheading' => 'Pick the tier that gets you closer to the music and the artist.',
                'events_heading' => 'Upcoming <span class="gradient-text-gold">Shows</span>',
                'events_subheading' => 'Get tickets to exclusive performances and fan club parties.',
                'cta_heading' => 'Ready to Join the Family?',
                'cta_subheading' => 'Step into ' . $celebrity->name . '\'s world. Backstage access, exclusive music, and a community that feels like home.',
                'stats' => [
                    ['value' => '15', 'label' => '#1 Hits'],
                    ['value' => '10M+', 'label' => 'Albums Sold'],
                    ['value' => '500+', 'label' => 'Tour Cities'],
                    ['value' => '20', 'label' => 'Years on Tour'],
                ],
                'about_title' => 'The Story Behind the Music',
                'about_body' => '<p>' . $celebrity->name . ' brings the heart and soul of country music to fans around the world. From humble beginnings to sold-out arenas, every song tells a story.</p><p>This is the official fan community — a place where real country music lovers come together. Join the family.</p>',
                'features' => [
                    'membership' => ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Fan Membership', 'Join the official fan club. Get exclusive merch, early concert access, and a community that feels like family.'],
                    'meet_greet' => ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Meet & Greet', 'VIP concert experiences, backstage passes, and intimate acoustic sessions with the star.'],
                    'membership_card' => ['M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'Fan Card', 'Your official fan club card for VIP concert entry, merch discounts, and exclusive event access.'],
                    'private_meetup' => ['M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Private Meetup', 'Request a personal meet-up with the artist. A moment you\'ll cherish forever.'],
                    'messaging' => ['M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'Fan Mail', 'Stay in touch with the management team and the fan community. We\'re always here.'],
                    'fan_applications' => ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Fan Verification', 'Apply to become a verified fan and unlock the full country music fan experience.'],
                ],
            ],
            'adult_star' => [
                'section_heading' => 'Premium & Exclusive',
                'section_subheading' => 'Your private fan experience',
                'features_heading' => 'Everything for <span class="gradient-text-gold">Premium Members</span>',
                'features_subheading' => 'Exclusive content, private messaging, and VIP perks for the ultimate fan experience.',
                'pricing_heading' => 'Your <span class="gradient-text-gold">Premium</span> Access',
                'pricing_subheading' => 'Choose the membership that unlocks the content and connection you want.',
                'events_heading' => 'Exclusive <span class="gradient-text-gold">Events</span>',
                'events_subheading' => 'Private events and special appearances just for premium members.',
                'cta_heading' => 'Ready for the Ultimate Experience?',
                'cta_subheading' => 'Join ' . $celebrity->name . '\'s exclusive community. Premium content, private access, and more.',
                'stats' => [
                    ['value' => '500+', 'label' => 'Exclusive Posts'],
                    ['value' => '50K+', 'label' => 'Premium Members'],
                    ['value' => '8', 'label' => 'Years Active'],
                    ['value' => '10K+', 'label' => 'Fan Interactions'],
                ],
                'about_title' => 'Your Premium Fan Destination',
                'about_body' => '<p>' . $celebrity->name . ' invites you into an exclusive world of premium content, private interactions, and VIP perks.</p><p>This is the official fan community — a private space where premium members connect, engage, and access content you won\'t find anywhere else.</p>',
                'features' => [
                    'membership' => ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Premium Membership', 'Unlock exclusive content, priority messaging, and VIP perks across multiple tiers.'],
                    'meet_greet' => ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'VIP Events', 'Attend exclusive premium events and private gatherings for top-tier members.'],
                    'membership_card' => ['M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'VIP Card', 'Your elite digital membership card for premium access at all events and exclusive perks.'],
                    'private_meetup' => ['M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Private Meetup', 'Request an exclusive one-on-one private session. Personal and unforgettable.'],
                    'messaging' => ['M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'Direct Messaging', 'Send private messages directly. Premium members get priority responses.'],
                    'fan_applications' => ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Fan Verification', 'Apply to become a verified premium member and unlock the full experience.'],
                ],
            ],
            'musician' => [
                'section_heading' => 'Music & Concert Central',
                'section_subheading' => 'Live the music',
                'features_heading' => 'Everything for <span class="gradient-text-gold">Real Music Fans</span>',
                'features_subheading' => 'Early access to drops, exclusive merch, concert priority, and behind-the-scenes content.',
                'pricing_heading' => 'Your <span class="gradient-text-gold">Backstage</span> Pass',
                'pricing_subheading' => 'Choose the tier that gets you closer to the music and the artist.',
                'events_heading' => 'Upcoming <span class="gradient-text-gold">Shows</span>',
                'events_subheading' => 'Get priority tickets to concerts and exclusive fan events.',
                'cta_heading' => 'Ready to Feel the Music?',
                'cta_subheading' => 'Join ' . $celebrity->name . '\'s community. Early access to new music, exclusive merch, and concert priority.',
                'stats' => [
                    ['value' => '10M+', 'label' => 'Monthly Listeners'],
                    ['value' => '5', 'label' => 'Studio Albums'],
                    ['value' => '200+', 'label' => 'Sold-Out Shows'],
                    ['value' => '50+', 'label' => 'Music Awards'],
                ],
                'about_title' => 'The Sound of a Generation',
                'about_body' => '<p>' . $celebrity->name . ' creates music that moves millions. From chart-topping hits to sold-out world tours, every performance is unforgettable.</p><p>This is the official fan community — your backstage pass to exclusive content, early access, and a community of passionate fans.</p>',
                'features' => [
                    'membership' => ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Fan Membership', 'Get early access to new music drops, exclusive merch drops, and priority concert ticket access.'],
                    'meet_greet' => ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Meet & Greet', 'VIP concert experiences, soundcheck access, and photo opportunities with the artist.'],
                    'membership_card' => ['M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'Fan Card', 'Your official fan club card for concert priority entry, merch discounts, and VIP access.'],
                    'private_meetup' => ['M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Private Meetup', 'Request a personal meet-up with the artist. A moment you\'ll never forget.'],
                    'messaging' => ['M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'Fan Mail', 'Send messages to the management team and stay connected with the fan community.'],
                    'fan_applications' => ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Fan Verification', 'Apply to become a verified fan and unlock the full music fan experience.'],
                ],
            ],
        ];
        $defaults = $catDefaults[$cat] ?? $catDefaults['musician'];
    @endphp

    @include('celebrity.partials.hero')

    <div class="section-divider"></div>

    {{-- ─── STATS ─── --}}
    <section class="relative -mt-10 md:-mt-16 container-x z-10">
        <div class="glass-strong rounded-2xl p-8 md:p-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @php
                    $stats = $content['stats'] ?? $defaults['stats'];
                @endphp
                @foreach ($stats as $stat)
                    <div class="space-y-1">
                        <div class="text-3xl md:text-4xl font-bold count-highlight">{{ $stat['value'] }}</div>
                        <div class="text-sm text-gray-500 font-medium">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── GALLERY ─── --}}
    @php $gallery = $celebrity->getGalleryImages(); @endphp
    <section class="section" style="background: var(--accent-light);">
        <div class="container-x">
            <div class="text-center mb-12 space-y-4">
                <span class="eyebrow">Gallery</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">Moments with <span class="gradient-text-gold">{{ $celebrity->name }}</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">A glimpse into the world of your favorite celebrity through exclusive photos and memories.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($gallery as $index => $img)
                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 @if($index < 2) md:col-span-2 md:row-span-2 @endif @if($index === 0) lg:col-span-1 @endif cursor-pointer" onclick="openLightbox({{ $index }})">
                        <img src="{{ $img }}" alt="{{ $celebrity->name }} gallery image {{ $index + 1 }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── LIGHTBOX ─── --}}
    <div id="lightbox" class="fixed inset-0 z-50 bg-black/95 hidden items-center justify-center" onclick="closeLightbox(event)">
        <button onclick="closeLightbox(event)" class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition z-10" type="button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button onclick="prevImage()" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition z-10" type="button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button onclick="nextImage()" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition z-10" type="button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            @foreach ($gallery as $index => $img)
                <button onclick="event.stopPropagation(); goToImage({{ $index }})" class="lightbox-dot w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white/60 transition" data-index="{{ $index }}" type="button"></button>
            @endforeach
        </div>
        <img id="lightbox-img" class="max-w-[90vw] max-h-[90vh] object-contain rounded-2xl shadow-2xl" alt="">
    </div>

    <script>
        const galleryImages = {!! json_encode($gallery) !!};
        let currentIndex = 0;

        function openLightbox(index) {
            currentIndex = index;
            const lb = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            img.src = galleryImages[index];
            lb.classList.remove('hidden');
            lb.classList.add('flex');
            document.body.style.overflow = 'hidden';
            updateDots();
        }

        function closeLightbox(e) {
            if (e && e.target !== e.currentTarget) return;
            const lb = document.getElementById('lightbox');
            lb.classList.add('hidden');
            lb.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
            document.getElementById('lightbox-img').src = galleryImages[currentIndex];
            updateDots();
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % galleryImages.length;
            document.getElementById('lightbox-img').src = galleryImages[currentIndex];
            updateDots();
        }

        function goToImage(index) {
            currentIndex = index;
            document.getElementById('lightbox-img').src = galleryImages[index];
            updateDots();
        }

        function updateDots() {
            document.querySelectorAll('.lightbox-dot').forEach(dot => {
                dot.classList.toggle('bg-white/80', parseInt(dot.dataset.index) === currentIndex);
                dot.classList.toggle('bg-white/30', parseInt(dot.dataset.index) !== currentIndex);
            });
        }

        document.addEventListener('keydown', function(e) {
            if (!document.getElementById('lightbox').classList.contains('hidden')) {
                if (e.key === 'Escape') closeLightbox(e);
                if (e.key === 'ArrowLeft') prevImage();
                if (e.key === 'ArrowRight') nextImage();
            }
        });
    </script>

    <div class="section-divider"></div>

    {{-- ─── ABOUT ─── --}}
    <section class="section">
        <div class="container-x">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="eyebrow">About</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        {{ $content['about_title'] ?? $defaults['about_title'] }}
                    </h2>
                    <div class="text-gray-600 leading-relaxed space-y-4 text-lg">
                        {!! $content['about_body'] ?? $defaults['about_body'] !!}
                    </div>
                    <div class="flex gap-4 pt-2">
                        @if ($celebrity->social_links['instagram'] ?? false)
                            <a href="{{ $celebrity->social_links['instagram'] }}" target="_blank" class="flex items-center gap-2 text-sm font-semibold transition hover:translate-x-1" style="color: var(--accent);">
                                Follow on Instagram
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-xl">
                        @if ($celebrity->cover_photo)
                            <img src="{{ $celebrity->getCoverUrl() }}" alt="{{ $celebrity->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full mesh-gradient flex items-center justify-center">
                                <span class="text-9xl font-bold gradient-text opacity-50">{{ strtoupper(substr($celebrity->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 rounded-2xl flex items-center justify-center shadow-lg border border-white/20 text-white" style="background: var(--accent-gradient);">
                        <div class="text-center">
                            <div class="text-3xl font-bold">{{ date('Y') - 2016 }}</div>
                            <div class="text-xs opacity-80">Years</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    {{-- ─── FEATURES ─── --}}
    @if (collect($features)->filter()->isNotEmpty())
    <section class="section" style="background: var(--accent-light);">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">{{ $content['features_badge'] ?? $defaults['section_heading'] }}</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">{!! $content['features_heading'] ?? $defaults['features_heading'] !!}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">{{ $content['features_subheading'] ?? $defaults['features_subheading'] }}</p>
            </div>

            <div class="flex flex-wrap justify-center gap-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                @php
                    $featureIcons = $defaults['features'];
                    $featureNames = [
                        'membership' => 'Membership',
                        'meet_greet' => 'Meet & Greet',
                        'membership_card' => 'Membership Card',
                        'private_meetup' => 'Private Meetup',
                        'messaging' => 'Messaging',
                        'fan_applications' => 'Fan Applications',
                    ];
                    $featureRoutePrefixes = [
                        'membership' => 'celebrity.membership',
                        'meet_greet' => 'celebrity.meet-greet',
                        'membership_card' => 'celebrity.membership-card',
                        'private_meetup' => 'celebrity.private-meetup',
                        'messaging' => 'celebrity.messages',
                        'fan_applications' => 'celebrity.apply',
                    ];
                @endphp
                @foreach ($features as $key => $enabled)
                    @if ($enabled && isset($featureIcons[$key]))
                        @php $icon = $featureIcons[$key]; @endphp
                        <a href="{{ route($featureRoutePrefixes[$key] ?? 'celebrity.home', ['celebrity' => $celebrity->slug]) }}" class="group card-glow bg-white rounded-2xl p-8 border shadow-sm hover:shadow-xl" style="border-color: color-mix(in srgb, var(--accent) 12%, transparent);">
                            <div class="feature-card-header w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-transform group-hover:scale-110" style="background: var(--accent-soft-bg); color: var(--accent-deep);">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon[0] }}"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $icon[1] }}</h3>
                            <p class="text-gray-500 leading-relaxed">{{ $icon[2] }}</p>
                            <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold transition group-hover:gap-2 animate-shine" style="color: var(--accent);">
                                Learn more
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <div class="section-divider"></div>

    {{-- ─── MEMBERSHIP TIERS ─── --}}
    @if (($features['membership'] ?? false) && count($tiers))
    <section class="section">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">{{ $content['pricing_badge'] ?? $defaults['section_heading'] }}</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">{!! $content['pricing_heading'] ?? $defaults['pricing_heading'] !!}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">{{ $content['pricing_subheading'] ?? $defaults['pricing_subheading'] }}</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6 [&>*]:grow [&>*]:basis-60 [&>*]:max-w-sm">
                @foreach ($tiers as $tier)
                    <div class="group relative bg-white rounded-2xl p-8 border shadow-sm transition-all duration-300 hover:-translate-y-2 card-glow ring-glow-hover" style="border-color: color-mix(in srgb, var(--accent) 15%, transparent);">
                        <div class="w-12 h-1 rounded-full mb-6" style="background: {{ $tier['color'] ?? $theme['primary_color'] ?? 'var(--accent)' }};"></div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $tier['name'] }}</h3>
                        <div class="mb-6">
                            <span class="price-glow text-4xl font-bold text-gray-900">${{ number_format($tier['price'], 0) }}</span>
                            <span class="text-gray-400 text-sm">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            @foreach ($tier['benefits'] ?? [] as $benefit)
                                <li class="flex items-start gap-3 text-sm text-gray-600">
                                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $benefit }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="btn-primary w-full text-center cta-pulse">
                            Get Started
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <div class="section-divider"></div>

    {{-- ─── UPCOMING EVENTS ─── --}}
    @if ($features['meet_greet'] ?? false)
    @php
        $events = \App\Models\MeetGreetEvent::where('celebrity_id', $celebrity->id)
            ->where('is_active', true)
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();
    @endphp
    @if ($events->count())
    <section class="section" style="background: var(--accent-light);">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">{{ $content['events_badge'] ?? $defaults['section_heading'] }}</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">{!! $content['events_heading'] ?? $defaults['events_heading'] !!}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">{{ $content['events_subheading'] ?? $defaults['events_subheading'] }}</p>
            </div>

            <div class="flex flex-wrap justify-center gap-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                @foreach ($events as $event)
                    <div class="group bg-white rounded-2xl overflow-hidden border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 card-glow" style="border-color: color-mix(in srgb, var(--accent) 12%, transparent);">
                        <div class="h-48 relative overflow-hidden" style="background: var(--accent-gradient);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <div class="text-5xl font-bold">{{ $event->date->format('d') }}</div>
                                    <div class="text-lg font-semibold opacity-80">{{ $event->date->format('M Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:accent-text transition">{{ $event->title }}</h3>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->location }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <span class="price-glow">${{ number_format($event->price, 0) }}</span>
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed">{{ $event->description }}</p>
                            @auth
                                <a href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}" class="btn-primary w-full text-center">Get Tickets</a>
                            @else
                                <a href="{{ route('register') }}" class="btn-ghost w-full text-center">Join to Attend</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @endif

    <div class="section-divider"></div>

    {{-- ─── TESTIMONIALS ─── --}}
    @if (count($content['testimonials'] ?? []))
    <section class="section">
        <div class="container-x">
            <div class="text-center mb-16 space-y-4">
                <span class="eyebrow">Testimonials</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">What <span class="gradient-text-gold">Fans Say</span></h2>
            </div>

            <div class="flex flex-wrap justify-center gap-8 [&>*]:grow [&>*]:basis-80 [&>*]:max-w-sm">
                @foreach ($content['testimonials'] as $testimonial)
                    <div class="card-glow bg-white rounded-2xl p-8 border shadow-sm hover:shadow-lg transition-all duration-300" style="border-color: color-mix(in srgb, var(--accent) 12%, transparent);">
                        <div class="flex gap-1 mb-6">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" style="color: var(--accent);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $testimonial['quote'] ?? '' }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold" style="background: var(--accent-gradient);">
                                {{ strtoupper(substr($testimonial['author'] ?? 'F', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $testimonial['author'] ?? '' }}</p>
                                @if ($testimonial['badge'] ?? false)
                                    <p class="text-xs font-medium" style="color: var(--accent);">{{ $testimonial['badge'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ─── CTA ─── --}}
    <section class="relative overflow-hidden py-28" style="background: var(--accent-gradient);">
        <div class="absolute inset-0 opacity-10 banner-gradient">
            <div class="absolute top-10 left-10 w-40 h-40 rounded-full bg-white animate-float"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 rounded-full bg-white animate-blob-reverse"></div>
            <div class="absolute top-1/2 left-1/2 w-80 h-80 rounded-full bg-white/20 animate-spin-slow"></div>
        </div>
        <div class="relative container-x text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                {!! $content['cta_heading'] ?? $defaults['cta_heading'] !!}
            </h2>
            <p class="text-white/80 text-lg mb-10 max-w-xl mx-auto">{{ $content['cta_subheading'] ?? $defaults['cta_subheading'] }}</p>
            <div class="flex flex-wrap justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-gray-900 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300 cta-pulse animate-shine">
                        Create Your Account
                    </a>
                @endguest
                @auth
                    <a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="bg-white text-gray-900 px-10 py-4 rounded-full text-lg font-bold hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300 cta-pulse animate-shine">
                        View Membership Plans
                    </a>
                @endauth
                @if ($celebrity->social_links['instagram'] ?? false)
                    <a href="{{ $celebrity->social_links['instagram'] }}" target="_blank" class="border-2 border-white/40 text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-white/10 hover:border-white/70 transition-all duration-300">
                        Follow on Instagram
                    </a>
                @endif
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.counter').forEach(el => {
            const target = parseInt(el.dataset.target);
            const duration = 2000;
            const step = Math.ceil(target / (duration / 16));
            let current = 0;
            const update = () => {
                current += step;
                if (current >= target) { el.textContent = target; return; }
                el.textContent = current;
                requestAnimationFrame(update);
            };
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    update();
                    observer.unobserve(el);
                }
            }, { threshold: 0.5 });
            observer.observe(el);
        });
    </script>
</x-app-layout>
