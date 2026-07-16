<footer class="mt-24 bg-gray-950 text-gray-300">
    <div class="container-x py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="md:col-span-1">
                <a href="{{ ($celebrity ?? null) ? url('/') : '/' }}" class="text-2xl font-display font-bold text-white">
                    @if ($celebrity ?? null)
                        {{ $celebrity->name }}
                    @else
                        Jennie<span class="accent-text">Kim</span>
                    @endif
                </a>
                <p class="mt-4 text-sm text-gray-400 leading-relaxed">
                    @if (($celebrity ?? null) && ($celebrity->config['site_content']['about_body'] ?? false))
                        {{ strip_tags(Str::limit($celebrity->config['site_content']['about_body'], 120)) }}
                    @else
                        The official fan community. Exclusive memberships, meet &amp; greets, and moments you'll never forget.
                    @endif
                </p>
                @if (($celebrity ?? null) && $celebrity->social_links)
                <div class="flex gap-3 mt-6">
                    @foreach (['instagram', 'twitter', 'youtube'] as $social)
                        @if ($celebrity->social_links[$social] ?? false)
                            <a href="{{ $celebrity->social_links[$social] }}" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center transition hover:scale-110" aria-label="{{ ucfirst($social) }}" target="_blank" style="background-color: color-mix(in srgb, var(--accent) 100%, black 30%);">
                                @if ($social === 'instagram')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.86s0 3.6-.07 4.86c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.9.07s-3.6 0-4.86-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 01-1.38-.9 3.7 3.7 0 01-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.21 15.6 2.2 15.2 2.2 12s0-3.6.07-4.86c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.4 2.21 8.8 2.2 12 2.2zm0 1.8c-3.15 0-3.5 0-4.74.07-.9.04-1.38.2-1.7.32-.43.17-.74.37-1.06.69-.32.32-.52.63-.69 1.06-.13.32-.28.8-.32 1.7C3.42 8.5 3.4 8.85 3.4 12s0 3.5.07 4.74c.04.9.2 1.38.32 1.7.17.43.37.74.69 1.06.32.32.63.52 1.06.69.32.13.8.28 1.7.32 1.24.07 1.6.07 4.74.07s3.5 0 4.74-.07c.9-.04 1.38-.2 1.7-.32.43-.17.74-.37 1.06-.69.32-.32.52-.63.69-1.06.13-.32.28-.8.32-1.7.07-1.24.07-1.6.07-4.74s0-3.5-.07-4.74c-.04-.9-.2-1.38-.32-1.7a2.85 2.85 0 00-.69-1.06 2.85 2.85 0 00-1.06-.69c-.32-.13-.8-.28-1.7-.32C15.5 4 15.15 4 12 4zm0 3.06a4.94 4.94 0 110 9.88 4.94 4.94 0 010-9.88zm0 8.14a3.2 3.2 0 100-6.4 3.2 3.2 0 000 6.4zm6.3-8.34a1.15 1.15 0 11-2.3 0 1.15 1.15 0 012.3 0z"/></svg>
                                @elseif ($social === 'twitter')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.9 2H22l-7.5 8.6L23 22h-6.8l-5.3-7-6.1 7H1.7l8-9.2L1 2h7l4.8 6.4L18.9 2zm-2.4 18h1.9L7.6 4H5.6l10.9 16z"/></svg>
                                @elseif ($social === 'youtube')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 12s0-3.2-.4-4.7c-.2-.8-.9-1.5-1.7-1.7C19.4 5.2 12 5.2 12 5.2s-7.4 0-8.9.4c-.8.2-1.5.9-1.7 1.7C1 8.8 1 12 1 12s0 3.2.4 4.7c.2.8.9 1.5 1.7 1.7 1.5.4 8.9.4 8.9.4s7.4 0 8.9-.4c.8-.2 1.5-.9 1.7-1.7.4-1.5.4-4.7.4-4.7zM9.8 15.3V8.7l5.7 3.3-5.7 3.3z"/></svg>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Community</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @if ($celebrity ?? null)
                        @if ($celebrity->config['features']['membership'] ?? false)
                            <li><a href="{{ route('celebrity.membership', ['celebrity' => $celebrity->slug]) }}" class="hover:accent-text transition">Memberships</a></li>
                        @endif
                        @if ($celebrity->config['features']['meet_greet'] ?? false)
                            <li><a href="{{ route('celebrity.meet-greet', ['celebrity' => $celebrity->slug]) }}" class="hover:accent-text transition">Meet &amp; Greets</a></li>
                        @endif
                        @if ($celebrity->config['features']['private_meetup'] ?? false)
                            <li><a href="{{ route('celebrity.private-meetup', ['celebrity' => $celebrity->slug]) }}" class="hover:accent-text transition">Private Meetups</a></li>
                        @endif
                        @if ($celebrity->config['features']['fan_applications'] ?? false)
                            <li><a href="{{ route('celebrity.apply', ['celebrity' => $celebrity->slug]) }}" class="hover:accent-text transition">Apply to Join</a></li>
                        @endif
                    @endif
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Member</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @if ($celebrity ?? null)
                         <li><a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}" class="hover:accent-text transition">My Dashboard</a></li>
                         <li><a href="{{ route('celebrity.profile.edit', ['celebrity' => $celebrity->slug]) }}" class="hover:accent-text transition">Profile</a></li>
                     @endif
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Stay in the loop</h4>
                <p class="text-sm text-gray-400 mb-3">Get early access to events and drops.</p>
                <form class="flex" onsubmit="return false;">
                    <input type="email" placeholder="you@email.com" class="flex-1 bg-white/10 rounded-l-full px-4 py-2 text-sm text-white placeholder-gray-500 outline-none focus:ring-2" style="focus:ring-color: var(--accent);">
                    <button class="px-4 py-2 rounded-r-full text-sm font-semibold transition text-white" style="background-color: var(--accent);">Join</button>
                </form>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ ($celebrity ?? null) ? $celebrity->name . ' Fan Community' : 'JennieKim Fan Community' }}. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:accent-text transition">Privacy</a>
                <a href="#" class="hover:accent-text transition">Terms</a>
                <a href="#" class="hover:accent-text transition">Contact</a>
            </div>
        </div>
    </div>
</footer>
