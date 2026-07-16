@props(['user', 'size' => 'md', 'class' => ''])

@php
    $sizes = ['sm' => 'w-7 h-7 text-[10px]', 'md' => 'w-9 h-9 text-xs', 'lg' => 'w-12 h-12 text-sm', 'xl' => 'w-16 h-16 text-xl'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $avatarUrl = $user?->avatarUrl();
    $initial = $user ? strtoupper(substr($user->name, 0, 1)) : '?';
@endphp

@if ($avatarUrl)
    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}"
         class="{{ $sizeClass }} rounded-full object-cover ring-2 ring-white/60 shadow-sm {{ $class }}">
@else
    <div class="{{ $sizeClass }} rounded-full bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white font-bold ring-2 ring-white/60 shadow-sm {{ $class }}">
        {{ $initial }}
    </div>
@endif
