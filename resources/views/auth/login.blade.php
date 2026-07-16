@php
    $celeb = $celebrity ?? null;
    $primary = $celeb ? ($celeb->config['theme']['primary_color'] ?? '#ec4899') : '#ec4899';
@endphp

<x-guest-layout :celebrity="$celeb">
    <div class="text-center mb-9">
        <div class="w-14 h-14 rounded-2xl mx-auto mb-5 flex items-center justify-center shadow-lg"
             style="background: linear-gradient(135deg, {{ $primary }}, color-mix(in srgb, {{ $primary }} 70%, black)); box-shadow: 0 4px 16px color-mix(in srgb, {{ $primary }} 30%, transparent);">
            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
        </div>
        <h2 class="text-[27px] font-bold text-gray-900 leading-tight" style="font-family: var(--font-heading, ui-serif, Georgia, serif);">Welcome back</h2>
        @if ($celeb)
            <p class="text-sm mt-2" style="color: color-mix(in srgb, var(--accent) 55%, gray);">Sign in to your {{ $celeb->name }} fan account</p>
        @else
            <p class="text-sm text-gray-500 mt-2">Sign in to your account</p>
        @endif
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ $celeb ? url()->current() : route('login') }}" class="space-y-5">
        @csrf

        <div class="input-group">
            <label class="auth-label" for="email">Email address</label>
            <div class="relative">
                <span class="input-icon text-gray-400">
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <x-text-input id="email" class="auth-input w-full pl-10 pr-4 py-3 text-sm rounded-xl border border-gray-200 bg-white/70" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
                <div class="input-accent-line" style="background: var(--accent);"></div>
            </div>
            @if ($errors->has('email'))
                <div class="field-error">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif
        </div>

        <div class="input-group" x-data="{ show: false }">
            <label class="auth-label" for="password">Password</label>
            <div class="relative">
                <span class="input-icon text-gray-400">
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <x-text-input id="password" class="auth-input w-full pl-10 pr-11 py-3 text-sm rounded-xl border border-gray-200 bg-white/70" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" @click="show = !show" class="pw-toggle absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg x-show="!show" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
                <div class="input-accent-line" style="background: var(--accent);"></div>
            </div>
            @if ($errors->has('password'))
                <div class="field-error">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $errors->first('password') }}</span>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between pt-0.5">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none group">
                <input id="remember_me" type="checkbox" class="auth-checkbox rounded border-gray-300 shadow-sm focus:ring-0" name="remember">
                <span class="text-sm text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="auth-link text-sm font-medium hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button type="submit"
                class="auth-btn w-full inline-flex items-center justify-center gap-2.5 px-5 py-3.5 text-sm font-semibold text-white rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2"
                style="background: linear-gradient(135deg, {{ $primary }}, color-mix(in srgb, {{ $primary }} 70%, black)); box-shadow: 0 4px 20px color-mix(in srgb, {{ $primary }} 35%, transparent), 0 1px 3px rgba(0,0,0,0.06);"
                x-on:click="$el.classList.add('loading'); $el.querySelector('svg').classList.add('animate-spin')">
            <svg class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            <span>{{ __('Sign in') }}</span>
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-8 auth-fade-in auth-fade-in-delay-5">
        New here?
        <a href="{{ $celeb ? route('celebrity.register', ['celebrity' => $celeb->slug]) : route('register') }}"
           class="auth-link font-semibold hover:underline">
            Create your account
        </a>
    </p>
</x-guest-layout>
