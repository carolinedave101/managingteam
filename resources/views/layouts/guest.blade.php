<!DOCTYPE html>
@php
    $celeb = $celebrity ?? null;
    $t = $celeb ? ($celeb->config['theme'] ?? []) : [];
    $primary = $t['primary_color'] ?? '#ec4899';
    $secondary = $t['secondary_color'] ?? '#8b5cf6';
    $fonts = $t['fonts'] ?? ['heading' => 'Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500', 'body' => 'Manrope:wght@400;500;600;700;800'];
    $headingFont = explode(':', $fonts['heading'])[0] ?? 'Playfair+Display';
    $bodyFont = explode(':', $fonts['body'])[0] ?? 'Manrope';
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $celeb ? $celeb->name . ' — Official Fan Community' : config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $celeb ? 'Join the official ' . $celeb->name . ' fan community.' : '' }}">
    <link rel="icon" href="{{ $celeb ? $celeb->getFaviconUrl() : '/favicon.svg' }}" type="image/svg+xml">
    <link rel="icon" href="{{ $celeb ? $celeb->getFaviconUrl() : '/favicon.ico' }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ $celeb ? $celeb->getAvatarUrl() : '/favicon.ico' }}">
    @if(!$celeb)<link rel="manifest" href="/site.webmanifest">@endif

    @if ($celeb)
        <style>
            :root {
                --accent: <?= $primary ?>;
                --accent-deep: <?= $primary ?>;
                --accent-light: <?= $primary ?>15;
                --accent-secondary: <?= $secondary ?>;
                --accent-soft-bg: <?= $primary ?>14;
                --accent-glow: <?= $primary ?>4D;
                --accent-glow-strong: <?= $primary ?>80;
                --font-heading: '<?= str_replace('+', ' ', $headingFont) ?>', ui-serif, Georgia, serif;
                --font-body: '<?= str_replace('+', ' ', $bodyFont) ?>', ui-sans-serif, system-ui, sans-serif;
            }
        </style>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family={{ $fonts['heading'] }}&family={{ $fonts['body'] }}&display=swap" rel="stylesheet">
    @else
        <style>
            :root {
                --accent: #ec4899;
                --accent-deep: #db2777;
                --accent-light: #fdf2f8;
                --accent-secondary: #8b5cf6;
                --accent-soft-bg: rgba(236, 72, 153, 0.08);
                --accent-glow: rgba(236, 72, 153, 0.3);
                --accent-glow-strong: rgba(236, 72, 153, 0.5);
                --font-heading: 'Playfair Display', ui-serif, Georgia, serif;
                --font-body: 'Manrope', ui-sans-serif, system-ui, sans-serif;
            }
        </style>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-input {
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
        }
        .auth-input:focus {
            --tw-ring-color: var(--accent) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--accent) 12%, transparent), 0 1px 3px rgba(0,0,0,0.04) !important;
            background-color: white !important;
        }
        .auth-checkbox {
            accent-color: var(--accent);
        }
        .auth-card {
            transition: transform 0.4s cubic-bezier(.34,1.56,.64,1), box-shadow 0.4s cubic-bezier(.34,1.56,.64,1);
        }
        .auth-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 80px color-mix(in srgb, var(--accent) 14%, transparent), 0 1px 3px rgba(0,0,0,0.04) !important;
        }
        .auth-link {
            color: var(--accent);
            transition: color 0.2s ease;
        }
        .auth-link:hover {
            color: color-mix(in srgb, var(--accent) 65%, black);
        }
        .auth-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(.34,1.56,.64,1);
        }
        .auth-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.18) 50%, transparent 60%);
            background-size: 250% 250%;
            transition: background-position 0.6s ease;
        }
        .auth-btn:hover::after {
            background-position: 100% 100%;
        }
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px color-mix(in srgb, var(--accent) 45%, transparent) !important;
        }
        .auth-btn:active {
            transform: translateY(0) scale(0.98);
        }
        .auth-btn.loading {
            pointer-events: none;
            opacity: 0.85;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            transition: color 0.25s ease, transform 0.25s ease;
        }
        .input-group:focus-within .input-icon {
            color: var(--accent);
            transform: translateY(-50%) scale(1.05);
        }
        .input-group .input-accent-line {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            border-radius: 1px;
            transition: width 0.3s ease, left 0.3s ease;
        }
        .input-group:focus-within .input-accent-line {
            width: 100%;
            left: 0;
        }
        .pw-toggle {
            transition: color 0.2s ease;
        }
        .pw-toggle:hover {
            color: var(--accent);
        }
        .field-error {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
            color: #dc2626;
            margin-top: 0.375rem;
            animation: error-shake 0.35s ease;
        }
        @keyframes error-shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
        .input-group:has(.field-error) .auth-input {
            border-color: #fca5a5;
        }
        .input-group:has(.field-error) .auth-input:focus {
            border-color: var(--accent) !important;
        }

        @keyframes accent-slide {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .accent-bar {
            background-size: 200% 100%;
            animation: accent-slide 4s ease-in-out infinite;
        }

        @keyframes auth-fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-fade-in {
            animation: auth-fade-up 0.6s cubic-bezier(.16,1,.3,1) forwards;
        }
        .auth-fade-in-delay-1 { animation-delay: 0.08s; opacity: 0; }
        .auth-fade-in-delay-2 { animation-delay: 0.16s; opacity: 0; }
        .auth-fade-in-delay-3 { animation-delay: 0.24s; opacity: 0; }
        .auth-fade-in-delay-4 { animation-delay: 0.32s; opacity: 0; }
        .auth-fade-in-delay-5 { animation-delay: 0.40s; opacity: 0; }

        @keyframes shine {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .logo-shimmer {
            background: linear-gradient(90deg, var(--accent) 0%, color-mix(in srgb, var(--accent) 60%, white) 50%, var(--accent) 100%);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shine 3s ease-in-out infinite;
        }

        .auth-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.375rem;
            display: block;
            transition: color 0.2s ease;
        }
        .input-group:focus-within .auth-label {
            color: var(--accent);
        }
    </style>
</head>
<body style="font-family: var(--font-body, 'Figtree', ui-sans-serif, system-ui, sans-serif);">
    <div class="min-h-screen flex relative overflow-hidden">
        {{-- Background layer --}}
        <div class="absolute inset-0 z-0 mesh-gradient"></div>

        {{-- Decorative blobs --}}
        <div class="absolute -top-28 -right-28 w-80 h-80 rounded-full opacity-20 animate-blob"
             style="background: radial-gradient(circle, var(--accent) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-36 -left-36 w-[440px] h-[440px] rounded-full opacity-15 animate-blob"
             style="background: radial-gradient(circle, var(--accent-secondary) 0%, transparent 70%); animation-delay: -5s;"></div>
        <div class="absolute top-1/4 -left-16 w-56 h-56 rounded-full opacity-12 animate-blob"
             style="background: radial-gradient(circle, var(--accent) 0%, transparent 70%); animation-delay: -10s;"></div>
        <div class="absolute bottom-1/3 right-1/4 w-40 h-40 rounded-full opacity-10 animate-blob"
             style="background: radial-gradient(circle, var(--accent) 0%, transparent 70%); animation-delay: -3s;"></div>
        <div class="absolute top-1/2 left-1/3 w-24 h-24 rounded-full opacity-8 animate-blob"
             style="background: radial-gradient(circle, var(--accent-secondary) 0%, transparent 70%); animation-delay: -7s;"></div>

        {{-- Branded Sidebar — lg+ --}}
        @if ($celeb)
            <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 relative z-10 items-center justify-center overflow-hidden"
                 @if ($celeb->cover_photo)
                     style="background-image: url('{{ Storage::url($celeb->cover_photo) }}'); background-size: cover; background-position: center;"
                 @else
                     style="background: linear-gradient(145deg, {{ $primary }} 0%, {{ $secondary }} 100%);"
                @endif
            >
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.15) 45%, rgba(0,0,0,0.35) 100%);"></div>

                <div class="absolute top-16 right-16 w-28 h-28 rounded-full animate-float-slow opacity-15"
                     style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
                <div class="absolute bottom-24 left-12 w-20 h-20 rounded-full animate-float opacity-12"
                     style="background: radial-gradient(circle, white 0%, transparent 70%); animation-delay: -3s;"></div>
                <div class="absolute top-1/2 right-8 w-12 h-12 rounded-full animate-float-slow opacity-10"
                     style="background: radial-gradient(circle, white 0%, transparent 70%); animation-delay: -6s;"></div>

                <div class="relative z-10 text-center px-8 py-12 max-w-lg auth-fade-in">
                    @if ($celeb->avatar)
                        <img src="{{ Storage::url($celeb->avatar) }}" alt="{{ $celeb->name }}"
                             class="w-32 h-32 rounded-full mx-auto mb-6 border-[3px] border-white/25 shadow-2xl object-cover ring-[6px] ring-white/10">
                    @else
                        <div class="w-32 h-32 rounded-full mx-auto mb-6 border-[3px] border-white/25 shadow-2xl flex items-center justify-center ring-[6px] ring-white/10"
                             style="background: linear-gradient(135deg, {{ $primary }}, {{ $secondary }});">
                            <span class="text-6xl font-bold text-white" style="font-family: var(--font-heading);">{{ substr($celeb->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight" style="font-family: var(--font-heading, ui-serif, Georgia, serif);">{{ $celeb->name }}</h1>
                    @if ($celeb->bio)
                        <p class="text-white/75 text-base md:text-lg leading-relaxed max-w-sm mx-auto">{{ Str::limit($celeb->bio, 180) }}</p>
                    @endif
                    <div class="mt-8 flex items-center justify-center gap-3">
                        <span class="w-10 h-px bg-white/20"></span>
                        <span class="text-white/40 text-xs font-semibold uppercase tracking-[0.18em]">Official Fan Community</span>
                        <span class="w-10 h-px bg-white/20"></span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Auth Card Area --}}
        <div class="flex-1 flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-10 relative z-10">
            {{-- Header --}}
            @if ($celeb)
                <div class="lg:hidden text-center mb-8 auth-fade-in auth-fade-in-delay-1">
                    @if ($celeb->avatar)
                        <img src="{{ Storage::url($celeb->avatar) }}" alt="{{ $celeb->name }}"
                             class="w-16 h-16 rounded-full mx-auto mb-3 border-2 shadow object-cover"
                             style="border-color: var(--accent-light);">
                    @else
                        <div class="w-16 h-16 rounded-full mx-auto mb-3 border-2 flex items-center justify-center"
                             style="border-color: var(--accent-light); background: linear-gradient(135deg, {{ $primary }}, {{ $secondary }});">
                            <span class="text-2xl font-bold text-white">{{ substr($celeb->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <h1 class="text-xl font-bold text-gray-900" style="font-family: var(--font-heading, ui-serif, Georgia, serif);">{{ $celeb->name }}</h1>
                    <p class="text-xs text-gray-500 mt-0.5 uppercase tracking-[0.12em] font-medium">Official Fan Community</p>
                </div>
            @else
                <div class="text-center mb-8 auth-fade-in auth-fade-in-delay-1">
                    <a href="/" class="inline-flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-0.5"
                             style="background: linear-gradient(135deg, var(--accent), var(--accent-secondary));">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold logo-shimmer" style="font-family: var(--font-heading, ui-serif, Georgia, serif);">ManagingTeam</span>
                    </a>
                </div>
            @endif

            {{-- Card --}}
            <div class="w-full sm:max-w-md auth-fade-in auth-fade-in-delay-2">
                <div class="auth-card relative rounded-2xl sm:rounded-3xl px-8 py-10 sm:px-12 sm:py-12"
                     style="background: rgba(255, 255, 255, 0.88); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); box-shadow:
                        0 8px 40px color-mix(in srgb, var(--accent) 10%, transparent),
                        0 1px 3px rgba(0,0,0,0.04),
                        inset 0 1px 0 rgba(255,255,255,0.8);
                     border: 1px solid rgba(255,255,255,0.6);">

                    {{-- Gradient top accent bar with animated shimmer --}}
                    <div class="accent-bar absolute top-0 left-8 right-8 h-[3px] rounded-full"
                         style="background: linear-gradient(90deg, var(--accent), var(--accent-secondary), var(--accent), var(--accent-secondary));"></div>

                    {{-- Decorative corner accents --}}
                    <div class="absolute top-0 left-0 w-16 h-16 pointer-events-none overflow-hidden">
                        <div class="absolute top-0 left-0 w-4 h-[1px]" style="background: var(--accent); opacity: 0.3;"></div>
                        <div class="absolute top-0 left-0 w-[1px] h-4" style="background: var(--accent); opacity: 0.3;"></div>
                    </div>

                    {{ $slot }}
                </div>

                @if ($celeb)
                    <p class="text-center text-xs mt-6 auth-fade-in auth-fade-in-delay-4" style="color: color-mix(in srgb, var(--accent) 35%, gray);">
                        Powered by <a href="{{ route('landing') }}" class="font-medium hover:opacity-80 transition" style="color: var(--accent);">ManagingTeam</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
