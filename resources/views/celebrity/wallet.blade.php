<x-app-layout>
    <div class="mesh-gradient min-h-screen">
        <div class="max-w-5xl mx-auto px-4 py-8">
            {{-- Header --}}
            <div class="reveal is-visible mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">My <span class="gradient-text-gold">Wallet</span></h1>
                        <p class="text-sm text-gray-500">Manage your funds for the {{ $celebrity->name }} portal.</p>
                    </div>
                </div>
            </div>

            @if ($topupAmount)
                <div class="banner-gradient-soft rounded-xl p-4 mb-6 flex items-start gap-3" x-data x-init="$nextTick(() => document.getElementById('topUpModal').classList.add('modal-open'))">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-amber-800">Insufficient Balance</p>
                        <p class="text-sm text-amber-700">You need at least <strong>${{ number_format($topupAmount, 2) }}</strong> to complete your purchase. Please top up below, then you'll be redirected back automatically.</p>
                    </div>
                </div>
            @endif

            {{-- How it works --}}
            <div class="reveal is-visible glass-strong rounded-2xl border border-emerald-100 shadow-md p-5 mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h2 class="text-base font-bold text-gray-900">About Your Wallet</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                    <div class="p-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">Top Up</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Add funds to your wallet using any payment method.</p>
                    </div>
                    <div class="p-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">Spend Instantly</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Use wallet to pay for memberships, events, and more.</p>
                    </div>
                    <div class="p-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-700">No Upload Needed</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Wallet payments are instant — no proof upload required!</p>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- Balance card --}}
            <div class="reveal is-visible bg-gradient-to-br from-pink-500 via-purple-600 to-indigo-700 rounded-3xl p-8 text-white shadow-2xl mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-20 -mt-20 animate-float"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-16 -mb-16 animate-float-slow"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm text-white/70 uppercase tracking-wider font-semibold">Available Balance</p>
                            <p class="price-glow price-gold text-5xl font-bold mt-2" id="wallet-balance" data-balance="{{ $wallet->balance }}">${{ number_format($wallet->balance, 2) }}</p>
                            <p class="text-xs text-white/50 mt-2">Use your wallet for instant payments — no upload needed!</p>
                        </div>
                        <div class="w-16 h-16 bg-white/15 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="document.getElementById('topUpModal').classList.add('modal-open')"
                                class="animate-shine bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Top Up
                        </button>
                        <a href="{{ route('celebrity.dashboard', ['celebrity' => $celebrity->slug]) }}"
                           class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- Top-up modal --}}
            <div id="topUpModal" class="modal-overlay fixed inset-0 bg-black/50 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target===this)this.classList.remove('modal-open')">
                <div class="modal-content bg-white rounded-2xl p-8 max-w-lg w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Top Up Wallet</h3>
                            <p class="text-sm text-gray-500 mt-1">Add funds to your wallet for instant payments.</p>
                        </div>
                        <button onclick="document.getElementById('topUpModal').classList.remove('modal-open')" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('celebrity.wallet.top-up', ['celebrity' => $celebrity->slug]) }}" enctype="multipart/form-data"
                           x-data="formValidation">
                        @csrf
                        @if ($returnUrl)
                            <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                        @endif
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="amount" value="Amount" />
                                <p class="text-xs text-gray-400 mt-0.5 mb-1">How much would you like to add? Enter any amount of $1 or more.</p>
                                <div class="relative mt-1">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">$</span>
                                    <input type="number" id="amount" name="amount" step="0.01" min="1" required
                                           x-on:input.debounce.300ms="validate('amount', $el.value, [validators.required, validators.numeric, validators.min(1)])"
                                           x-on:blur="validate('amount', $el.value, [validators.required, validators.numeric, validators.min(1)])"
                                            x-bind:class="inputClass('amount')"
                                            class="form-input pl-8 text-lg font-bold"
                                           placeholder="0.00"
                                           value="{{ $topupAmount ? number_format($topupAmount, 2, '.', '') : '' }}">
                                </div>
                                <template x-if="invalid('amount')">
                                    <p x-text="errors.amount" class="text-red-500 text-xs mt-1"></p>
                                </template>
                                <template x-if="valid('amount')">
                                    <p class="text-green-600 text-xs mt-1">Amount looks good!</p>
                                </template>
                                @if ($topupAmount)
                                    <p class="text-xs text-amber-600 mt-1">Suggested minimum: ${{ number_format($topupAmount, 2) }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">💡 Top up at least the amount you need, or add a little extra for future purchases.</p>
                            </div>
                            <x-payment-methods
                                :methods="$paymentMethods"
                                :celebrity="$celebrity"
                                label="Payment Method"
                                amountLabel="Choose how to add funds"
                                :showWallet="false"
                            />
                            <button type="submit"
                                    class="cta-pulse w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    Add Funds
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- Pending deposits --}}
            @if ($pendingTopUps->count())
            <div class="reveal is-visible mb-8">
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h2 class="text-base font-bold text-amber-800">Pending Deposits ({{ $pendingTopUps->count() }})</h2>
                    </div>
                    <div class="space-y-2">
                        @foreach ($pendingTopUps as $txn)
                            <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-amber-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">${{ number_format($txn->amount, 2) }} — {{ $txn->description ?? 'Top-up' }}</p>
                                        <p class="text-xs text-gray-500">{{ $txn->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-amber-700 bg-amber-100 px-3 py-1 rounded-full">Pending Review</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-amber-700 mt-3">Your deposit will be credited once the admin reviews and approves your payment proof.</p>
                </div>
            </div>
            @endif

            <div class="section-divider"></div>

            {{-- Transaction history --}}
            <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Transaction History</h2>
                            <p class="text-xs text-gray-400">A record of all your wallet activity.</p>
                        </div>
                    </div>
                </div>

                @if ($transactions->count())
                    <div class="space-y-2">
                        @foreach ($transactions as $txn)
                            <div class="card-glow flex items-center justify-between p-4 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl {{ $txn->type === 'credit' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center shrink-0">
                                        @if ($txn->type === 'credit')
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                        @else
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">{{ $txn->description ?? ($txn->type === 'credit' ? 'Deposit' : 'Payment') }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $txn->created_at->format('M d, Y g:i A') }}
                                            @if ($txn->creator)
                                                · by {{ $txn->creator->name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold {{ $txn->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $txn->type === 'credit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <p class="font-semibold text-gray-500">No transactions yet</p>
                        <p class="text-sm text-gray-400 mt-1">Top up your wallet to get started. Your transaction history will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
