<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Celebrity Portals — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <div class="hero-gradient py-12 px-4">
            <div class="max-w-6xl mx-auto text-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-2xl shadow-lg mb-4">
                    <span class="text-2xl font-bold gradient-text">J</span>
                </a>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Celebrity Portals</h1>
                <p class="text-gray-500">Browse all available celebrity fan communities</p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 -mt-6 pb-12">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">Celebrity</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">Category</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">Gender</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">Country</th>
                                <th class="text-right px-4 py-3 font-semibold text-gray-600">Portal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($celebrities as $c)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $c->getAvatarUrl() }}" alt="" class="w-8 h-8 rounded-full object-cover bg-gray-200" loading="lazy">
                                            <span class="font-medium text-gray-900">{{ $c->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badgeColors = [
                                                'movie_star' => 'bg-indigo-100 text-indigo-700',
                                                'country_singer' => 'bg-amber-100 text-amber-700',
                                                'musician' => 'bg-pink-100 text-pink-700',
                                                'adult_star' => 'bg-purple-100 text-purple-700',
                                                'general' => 'bg-gray-100 text-gray-600',
                                            ];
                                            $color = $badgeColors[$c->category] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ $c->categoryLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($c->gender)
                                            <span class="inline-flex items-center gap-1 text-gray-600">
                                                @if ($c->gender === 'male')
                                                    <span>&#9794;</span>
                                                @else
                                                    <span>&#9792;</span>
                                                @endif
                                                {{ ucfirst($c->gender) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $c->country ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @php
                                            $url = parse_url(config('app.url'));
                                            $host = $url['host'] ?? 'localhost';
                                            $scheme = $url['scheme'] ?? 'http';
                                            $port = $url['port'] ?? null;
                                            $portal = $port ? "{$scheme}://{$c->slug}.{$host}:{$port}" : "{$scheme}://{$c->slug}.{$host}";
                                        @endphp
                                        <a href="{{ $portal }}" target="_blank" class="inline-flex items-center gap-1 text-pink-600 hover:text-pink-700 font-medium text-xs">
                                            Visit
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-gray-400">No celebrity portals available yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="text-center text-xs text-gray-400 mt-6">
                {{ $celebrities->count() }} celebrity portal{{ $celebrities->count() !== 1 ? 's' : '' }} available
            </p>
        </div>
    </div>
</body>
</html>
