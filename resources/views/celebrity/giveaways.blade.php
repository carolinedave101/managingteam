<x-app-layout>
    <div class="mesh-gradient-deep min-h-screen py-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 left-10 w-72 h-72 rounded-full bg-pink-500 animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 rounded-full bg-purple-500 animate-blob-reverse"></div>
        </div>

        <style>
            .modal-open { display: block !important; }
            [x-cloak] { display: none !important; }
        </style>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-6">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider mb-4" style="background: var(--accent-soft-bg, rgba(236,72,153,0.1)); color: var(--accent-deep, #db2777);">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: var(--accent, #ec4899);"></span>
                    Giveaways
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">Win <span class="gradient-text">Amazing</span> Prizes</h1>
                <p class="text-gray-500 max-w-xl mx-auto">Enter exclusive giveaways from {{ $celebrity->name }} for a chance to win prizes credited to your wallet.</p>
            </div>

            @if (session('success'))
                <div class="max-w-2xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-2xl mx-auto mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Active Giveaways --}}
            @php $activeGiveaways = $giveaways->filter(fn ($g) => $g->isActive()); @endphp
            @if ($activeGiveaways->count())
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($activeGiveaways as $giveaway)
                        <div class="bg-white rounded-2xl overflow-hidden border shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1" style="border-color: color-mix(in srgb, var(--accent, #ec4899) 12%, transparent);">
                            @if ($giveaway->prize_image_url)
                                <img src="{{ $giveaway->prize_image_url }}" alt="{{ $giveaway->prize_description }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 flex items-center justify-center" style="background: var(--accent-gradient, linear-gradient(135deg, #ec4899, #8b5cf6));">
                                    <svg class="w-16 h-16 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                </div>
                            @endif
                            <div class="p-6 space-y-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-xl font-bold text-gray-900">{{ $giveaway->title }}</h3>
                                        @if ($giveaway->fan_id)
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full" style="background: var(--accent-soft-bg, rgba(236,72,153,0.1)); color: var(--accent-deep, #db2777);">Just for You</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">{{ strip_tags($giveaway->description) }}</p>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Prize</span>
                                        <span class="font-semibold gradient-text-gold">${{ number_format($giveaway->prize_amount, 2) }} Wallet Credit</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Winners</span>
                                        <span class="font-semibold">{{ $giveaway->winner_count }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Entry Fee</span>
                                        <span class="font-semibold">{{ $giveaway->isFree() ? 'FREE' : '$'.number_format($giveaway->entry_fee, 2) }}</span>
                                    </div>
                                    @if ($giveaway->ends_at)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-500">Ends</span>
                                            <span class="font-semibold">{{ $giveaway->ends_at->diffForHumans() }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Entries</span>
                                        <span class="font-semibold">{{ $giveaway->getEntryCount() }}</span>
                                    </div>
                                </div>

                                @auth
                                    @php
                                        $userEntryCount = $giveaway->getEntryCountForUser(auth()->id());
                                        $canEnter = $userEntryCount < $giveaway->max_entries_per_fan;
                                    @endphp
                                    @if ($canEnter)
                                        <button onclick="document.getElementById('enter-giveaway-{{ $giveaway->id }}').classList.add('modal-open'); window.dispatchEvent(new CustomEvent('giveaway-reset-{{ $giveaway->id }}'))"
                                                class="w-full py-3 rounded-xl text-sm font-bold text-white transition shadow-md hover:shadow-lg"
                                                style="background: var(--accent-gradient, linear-gradient(135deg, #ec4899, #8b5cf6));">
                                            Enter Giveaway
                                        </button>
                                    @else
                                        <div class="w-full py-3 rounded-xl text-sm font-semibold text-center bg-gray-100 text-gray-500">
                                            Entered {{ $userEntryCount }} time{{ $userEntryCount !== 1 ? 's' : '' }}
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('celebrity.login', ['celebrity' => $celebrity->slug]) }}"
                                       class="block w-full py-3 rounded-xl text-sm font-bold text-center text-white transition shadow-md hover:shadow-lg"
                                       style="background: var(--accent-gradient, linear-gradient(135deg, #ec4899, #8b5cf6));">
                                        Login to Enter
                                    </a>
                                @endauth
                            </div>
                        </div>

                        {{-- Enter Modal --}}
                        @auth
                         <div id="enter-giveaway-{{ $giveaway->id }}" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm overflow-y-auto hidden" style="animation: fadeIn 0.15s ease;"
                              x-data="{ step: 'question', note: '' }"
                              x-on:giveaway-reset-{{ $giveaway->id }}.window="step = 'question'; note = ''">
                              <div class="min-h-full w-full flex flex-col items-start sm:items-center justify-center px-4 pt-4 pb-12 mt-32 sm:mt-0 sm:py-12">
                             <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl max-h-[85vh] flex flex-col overflow-hidden" @click.stop>

                                <div class="flex items-start justify-between p-6 pb-4 shrink-0">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900" x-text="step === 'question' ? 'Enter Giveaway' : 'Complete Entry'"></h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $giveaway->title }}</p>
                                    </div>
                                    <button type="button" onclick="document.getElementById('enter-giveaway-{{ $giveaway->id }}').classList.remove('modal-open')" class="p-1 text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                <div class="overflow-y-auto flex-1 min-h-0 px-6 pb-6">
                                    {{-- Prize Summary --}}
                                    <div class="bg-gray-50 rounded-xl p-4 space-y-2 text-sm mb-5">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Prize</span>
                                            <span class="font-semibold">${{ number_format($giveaway->prize_amount, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Entry Fee</span>
                                            <span class="font-semibold">{{ $giveaway->isFree() ? 'FREE' : '$'.number_format($giveaway->entry_fee, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Entries so far</span>
                                            <span class="font-semibold">{{ $giveaway->getEntryCount() }}</span>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('celebrity.giveaways.enter', ['celebrity' => $celebrity->slug, 'giveaway' => $giveaway->id]) }}" enctype="multipart/form-data">
                                        @csrf

                                        {{-- Step 1: Question --}}
                                        <div x-show="step === 'question'" x-cloak>
                                            <div class="mb-5">
                                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                                    Why do you love {{ $celebrity->name }}? <span class="text-gray-400 font-normal">(optional)</span>
                                                </label>
                                                <textarea x-model="note" name="heartfelt_note" rows="4" maxlength="500"
                                                          placeholder="Tell us what {{ $celebrity->name }} means to you and what winning would mean..."
                                                          class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-pink-400 focus:ring-pink-400 resize-none"></textarea>
                                                <p class="text-xs text-gray-400 mt-1 flex justify-between">
                                                    <span>Your note may be shared with {{ $celebrity->name }}!</span>
                                                    <span x-text="note.length + '/500'"></span>
                                                </p>
                                            </div>
                                            <div class="flex gap-3 pt-2">
                                                @if ($giveaway->isFree())
                                                    <button type="submit" class="flex-1 py-3 rounded-xl text-sm font-bold text-white transition shadow-md"
                                                            style="background: var(--accent-gradient, linear-gradient(135deg, #ec4899, #8b5cf6));">
                                                        Enter Now
                                                    </button>
                                                @else
                                                    <button type="button" @click="step = 'payment'" class="flex-1 py-3 rounded-xl text-sm font-bold text-white transition shadow-md"
                                                            style="background: var(--accent-gradient, linear-gradient(135deg, #ec4899, #8b5cf6));">
                                                        Continue — ${{ number_format($giveaway->entry_fee, 2) }}
                                                    </button>
                                                @endif
                                                <button type="button" onclick="document.getElementById('enter-giveaway-{{ $giveaway->id }}').classList.remove('modal-open')"
                                                        class="px-5 py-3 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium text-sm">Cancel</button>
                                            </div>
                                        </div>

                                        {{-- Step 2: Payment (only if entry fee > 0) --}}
                                        @if (!$giveaway->isFree())
                                        <div x-show="step === 'payment'" x-cloak>
                                            <x-payment-methods
                                                :methods="$paymentMethods"
                                                :wallet="$wallet"
                                                :celebrity="$celebrity"
                                                label="Payment Method"
                                                amountLabel="Entry fee: ${{ number_format($giveaway->entry_fee, 2) }}"
                                                :price="$giveaway->entry_fee"
                                            />
                                            <div class="flex gap-3 pt-2">
                                                <button type="submit" class="flex-1 py-3 rounded-xl text-sm font-bold text-white transition shadow-md"
                                                        style="background: var(--accent-gradient, linear-gradient(135deg, #ec4899, #8b5cf6));">
                                                    Complete Entry — ${{ number_format($giveaway->entry_fee, 2) }}
                                                </button>
                                                <button type="button" @click="step = 'question'"
                                                        class="px-5 py-3 border-2 border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium text-sm">Back</button>
                                            </div>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        @endauth
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background: color-mix(in srgb, var(--accent, #ec4899) 10%, transparent);">
                        <svg class="w-10 h-10" style="color: var(--accent, #ec4899);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700">No active giveaways right now</h3>
                    <p class="text-gray-400 mt-2">Check back soon for new giveaways from {{ $celebrity->name }}!</p>
                </div>
            @endif

            {{-- My Entries --}}
            @auth
                @if ($myEntries->count())
                    <div class="mt-16">
                        <div class="section-divider"></div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-10">My Entries</h2>
                        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b bg-gray-50">
                                            <th class="text-left px-4 py-3 font-semibold text-gray-600">#</th>
                                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Giveaway</th>
                                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Status</th>
                                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Prize</th>
                                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Entered</th>
                                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($myEntries as $entry)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-3 font-mono">#{{ $entry->entry_number }}</td>
                                                <td class="px-4 py-3 font-medium">{{ $entry->giveaway->title }}</td>
                                                <td class="px-4 py-3">
                                                    @php
                                                        $statusColors = ['entered' => 'bg-blue-100 text-blue-700', 'won' => 'bg-green-100 text-green-700', 'lost' => 'bg-gray-100 text-gray-500', 'cancelled' => 'bg-red-100 text-red-700'];
                                                        $statusLabels = ['entered' => 'Entered', 'won' => 'Winner!', 'lost' => 'Not Selected', 'cancelled' => 'Cancelled'];
                                                    @endphp
                                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$entry->status] ?? 'bg-gray-100 text-gray-500' }}">
                                                        {{ $statusLabels[$entry->status] ?? $entry->status }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 font-semibold">${{ number_format($entry->giveaway->prize_amount, 2) }}</td>
                                                <td class="px-4 py-3 text-gray-500">{{ $entry->created_at->format('M j, Y') }}</td>
                                                <td class="px-4 py-3 text-gray-500 max-w-xs">
                                                    @if ($entry->heartfelt_note)
                                                        <span class="text-xs italic text-gray-500 line-clamp-2" title="{{ e($entry->heartfelt_note) }}">"{{ Str::limit($entry->heartfelt_note, 60) }}"</span>
                                                    @else
                                                        <span class="text-xs text-gray-300">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Past Giveaways --}}
            @php $pastGiveaways = $giveaways->filter(fn ($g) => !$g->isActive() && $g->status !== 'draft'); @endphp
            @if ($pastGiveaways->count())
                <div class="mt-16">
                    <div class="section-divider"></div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-10">Past Giveaways</h2>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($pastGiveaways as $giveaway)
                            <div class="bg-white/60 rounded-xl p-5 border border-gray-100 opacity-75">
                                <h4 class="font-semibold text-gray-700">{{ $giveaway->title }}</h4>
                                <p class="text-xs text-gray-400 mt-1">Ended {{ $giveaway->ends_at?->diffForHumans() ?? 'N/A' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
