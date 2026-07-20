<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="hero-gradient min-h-screen flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-lg mx-auto text-center">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-6">
                    <span class="text-3xl font-bold gradient-text">J</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">
                    Celebrity<br><span class="gradient-text">Management</span>
                </h1>
                <p class="text-gray-500 text-lg">Enter a celebrity name to visit their portal.</p>
                <p class="text-gray-400 text-sm mt-1">Try <strong>jennie</strong>, <strong>jungkook</strong>, or <strong>lisa</strong></p>
            </div>

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100">
                <form method="POST" action="{{ route('landing.redirect') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="celebrity_link" class="sr-only">Celebrity Management Link</label>
                                <input
                            id="celebrity_link"
                            name="celebrity_link"
                            type="text"
                            placeholder="e.g. nickiminaj or nickiminaj.managingteam.info"
                            class="w-full px-5 py-4 rounded-xl border border-gray-200 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-center text-lg transition"
                            autofocus
                        >
                        @error('celebrity_link')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full !rounded-xl !py-4 !text-base">
                        Go to Portal
                    </button>
                </form>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('celebrities.index') }}" class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                        Browse all celebrity portals &rarr;
                    </a>
                </div>
                <p class="text-xs text-gray-400 mt-4">
                    Don't have a link?
                    <a href="{{ route('login') }}" class="text-pink-600 hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
