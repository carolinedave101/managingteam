<x-app-layout>
    <div class="mesh-gradient min-h-screen">
        <div class="max-w-5xl mx-auto px-4 py-8">
            {{-- Header --}}
            <div class="reveal is-visible mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Withdraw <span class="gradient-text-gold">Funds</span></h1>
                        <p class="text-sm text-gray-500">Request a withdrawal from your wallet to any of your saved accounts.</p>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="banner-gradient-soft rounded-xl p-4 mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left: Balance + Form --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Balance card --}}
                    <div class="reveal is-visible bg-gradient-to-br from-amber-500 via-orange-600 to-red-600 rounded-3xl p-6 text-white shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-16 -mt-16 animate-float"></div>
                        <div class="relative">
                            <p class="text-sm text-white/70 uppercase tracking-wider font-semibold">Available Balance</p>
                            <p class="price-glow text-4xl font-bold mt-2" data-wallet-balance="${{ number_format($wallet->balance, 2) }}">${{ number_format($wallet->balance, 2) }}</p>
                            <p class="text-xs text-white/50 mt-2">Funds are sent after the {{ $celebrity->name }} Management Team reviews your request.</p>
                        </div>
                    </div>

                    {{-- Withdrawal form --}}
                    @if ($accounts->count())
                    <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <h2 class="text-lg font-bold text-gray-900">Request a Withdrawal</h2>
                        </div>
                        <form method="POST" action="{{ route('celebrity.wallet.withdraw.store', ['celebrity' => $celebrity->slug]) }}"
                              x-data="formValidation">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="amount" value="Amount to Withdraw" />
                                    <p class="text-xs text-gray-400 mt-0.5 mb-1">How much would you like to withdraw? Must be at least $1.</p>
                                    <div class="relative mt-1">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">$</span>
                                        <input type="number" id="amount" name="amount" step="0.01" min="1" max="{{ $wallet->balance }}" required
                                               x-on:input.debounce.300ms="validate('amount', $el.value, [validators.required, validators.numeric, validators.min(1)])"
                                               x-on:blur="validate('amount', $el.value, [validators.required, validators.numeric, validators.min(1)])"
                                               x-bind:class="inputClass('amount')"
                                               class="form-input pl-8 text-lg font-bold"
                                               placeholder="0.00">
                                    </div>
                                    <template x-if="invalid('amount')">
                                        <p x-text="errors.amount" class="text-red-500 text-xs mt-1"></p>
                                    </template>
                                    <p class="text-xs text-gray-400 mt-1">💡 Maximum withdrawal: ${{ number_format($wallet->balance, 2) }}</p>
                                </div>

                                <div>
                                    <x-input-label for="withdrawal_account_id" value="Withdraw To" />
                                    <p class="text-xs text-gray-400 mt-0.5 mb-1">Select where to send your funds.</p>
                                    <select id="withdrawal_account_id" name="withdrawal_account_id" required
                                            class="form-input mt-1">
                                        <option value="">Select an account...</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $account->is_default ? 'selected' : '' }}>
                                                {{ $account->label }} ({{ ucfirst($account->type) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-amber-500 to-orange-600 text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        Request Withdrawal
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-8 text-center">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="font-semibold text-gray-700">No Withdrawal Accounts</p>
                        <p class="text-sm text-gray-500 mt-1 mb-4">Add a withdrawal account first (bank, CashApp, PayPal, or crypto) before requesting a withdrawal.</p>
                        <p class="text-xs text-gray-400">Use the "Add Account" form on this page to get started.</p>
                    </div>
                    @endif
                </div>

                {{-- Right: Accounts --}}
                <div class="space-y-6">
                    {{-- Saved accounts --}}
                    <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <h2 class="text-base font-bold text-gray-900">Saved Accounts</h2>
                            </div>
                            <button onclick="document.getElementById('addAccountModal').classList.add('modal-open')"
                                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                + Add
                            </button>
                        </div>

                        @if ($accounts->count())
                            <div class="space-y-2">
                                @foreach ($accounts as $account)
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shrink-0">
                                                @if ($account->type === 'bank')
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                                @elseif ($account->type === 'cashapp')
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                @elseif ($account->type === 'paypal')
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.374 8.663l1.337 6.316M8.577 11.71l6.817.613M11.29 8.577l.613 6.817M9 12h6"/></svg>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $account->label }}</p>
                                                <p class="text-xs text-gray-500 truncate">
                                                    {{ ucfirst($account->type) }}
                                                    @if ($account->is_default)
                                                        <span class="text-indigo-600 font-semibold"> · Default</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('celebrity.wallet.account.destroy', ['celebrity' => $celebrity->slug, 'account' => $account->id]) }}" class="shrink-0"
                                              onsubmit="return confirm('Remove this account?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 text-center py-4">No accounts saved yet. Add one to start withdrawing.</p>
                        @endif
                    </div>

                    {{-- Add Account Modal --}}
                    <div id="addAccountModal" class="modal-overlay fixed inset-0 bg-black/50 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target===this)this.classList.remove('modal-open')">
                        <div class="modal-content bg-white rounded-2xl p-8 max-w-lg w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Add Withdrawal Account</h3>
                                    <p class="text-sm text-gray-500 mt-1">Save an account to withdraw your wallet funds to.</p>
                                </div>
                                <button onclick="document.getElementById('addAccountModal').classList.remove('modal-open')" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('celebrity.wallet.account.store', ['celebrity' => $celebrity->slug]) }}"
                                  x-data="{ accountType: 'bank' }">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label value="Account Type" />
                                        <p class="text-xs text-gray-400 mt-0.5 mb-1">Choose the type of account you want to withdraw to.</p>
                                        <select x-model="accountType" name="type" required class="form-input mt-1">
                                            <option value="bank">Bank Account</option>
                                            <option value="cashapp">CashApp</option>
                                            <option value="paypal">PayPal</option>
                                            <option value="cryptocurrency">Cryptocurrency</option>
                                        </select>
                                    </div>

                                    <div>
                                        <x-input-label for="label" value="Account Label" />
                                        <p class="text-xs text-gray-400 mt-0.5 mb-1">Give this account a friendly name so you can identify it later.</p>
                                        <input type="text" id="label" name="label" required class="form-input mt-1"
                                               placeholder="e.g. My Checking Account, My BTC Wallet">
                                    </div>

                                    {{-- Bank fields --}}
                                    <template x-if="accountType === 'bank'">
                                        <div class="space-y-3 p-4 bg-gray-50 rounded-xl">
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Bank Details</p>
                                            <div>
                                                <x-input-label for="bank_name" value="Bank Name" />
                                                <input type="text" id="bank_name" name="details[bank_name]" required class="form-input mt-1" placeholder="e.g. Chase, Wells Fargo">
                                            </div>
                                            <div>
                                                <x-input-label for="account_name" value="Account Name" />
                                                <input type="text" id="account_name" name="details[account_name]" required class="form-input mt-1" placeholder="e.g. John Doe">
                                            </div>
                                            <div>
                                                <x-input-label for="account_number" value="Account Number" />
                                                <input type="text" id="account_number" name="details[account_number]" required class="form-input mt-1" placeholder="e.g. 123456789">
                                            </div>
                                            <div>
                                                <x-input-label for="routing_number" value="Routing Number" />
                                                <input type="text" id="routing_number" name="details[routing_number]" class="form-input mt-1" placeholder="e.g. 021000021">
                                            </div>
                                            <div>
                                                <x-input-label for="swift_code" value="SWIFT Code (International)" />
                                                <input type="text" id="swift_code" name="details[swift_code]" class="form-input mt-1" placeholder="e.g. BOFAUS3N">
                                            </div>
                                        </div>
                                    </template>

                                    {{-- CashApp fields --}}
                                    <template x-if="accountType === 'cashapp'">
                                        <div class="space-y-3 p-4 bg-gray-50 rounded-xl">
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">CashApp Details</p>
                                            <div>
                                                <x-input-label for="cashtag" value="$Cashtag" />
                                                <div class="relative mt-1">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">$</span>
                                                    <input type="text" id="cashtag" name="details[cashtag]" required class="form-input pl-7" placeholder="e.g. username">
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- PayPal fields --}}
                                    <template x-if="accountType === 'paypal'">
                                        <div class="space-y-3 p-4 bg-gray-50 rounded-xl">
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">PayPal Details</p>
                                            <div>
                                                <x-input-label for="paypal_email" value="PayPal Email" />
                                                <input type="email" id="paypal_email" name="details[email]" required class="form-input mt-1" placeholder="e.g. fan@email.com">
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Crypto fields --}}
                                    <template x-if="accountType === 'cryptocurrency'">
                                        <div class="space-y-3 p-4 bg-gray-50 rounded-xl">
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Cryptocurrency Details</p>
                                            <div>
                                                <x-input-label for="network" value="Network" />
                                                <select id="network" name="details[network]" required class="form-input mt-1">
                                                    <option value="bitcoin">Bitcoin (BTC)</option>
                                                    <option value="ethereum">Ethereum (ETH)</option>
                                                    <option value="usdt_trc20">USDT (TRC-20)</option>
                                                    <option value="usdt_erc20">USDT (ERC-20)</option>
                                                    <option value="usdt_bep20">USDT (BEP-20)</option>
                                                    <option value="bnb">BNB</option>
                                                    <option value="solana">Solana (SOL)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <x-input-label for="wallet_address" value="Wallet Address" />
                                                <input type="text" id="wallet_address" name="details[wallet_address]" required class="form-input mt-1"
                                                       placeholder="e.g. 1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa">
                                            </div>
                                        </div>
                                    </template>

                                    <button type="submit"
                                            class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                        Save Account
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-divider my-8"></div>

            {{-- Withdrawal history --}}
            <div class="reveal is-visible glass-strong rounded-2xl border border-white/60 shadow-lg p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Withdrawal History</h2>
                        <p class="text-xs text-gray-400">Track your withdrawal requests.</p>
                    </div>
                </div>

                @if ($withdrawals->count())
                    <div class="space-y-2">
                        @foreach ($withdrawals as $wd)
                            <div class="card-glow flex items-center justify-between p-4 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl
                                        @if($wd->status === 'approved') bg-green-100
                                        @elseif($wd->status === 'rejected') bg-red-100
                                        @else bg-amber-100 @endif
                                        flex items-center justify-center shrink-0">
                                        @if ($wd->status === 'approved')
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @elseif ($wd->status === 'rejected')
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        @else
                                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">${{ number_format($wd->amount, 2) }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $wd->created_at->format('M d, Y g:i A') }}
                                            @if ($wd->withdrawalAccount)
                                                · {{ $wd->withdrawalAccount->label }} ({{ ucfirst($wd->withdrawalAccount->type) }})
                                            @endif
                                        </p>
                                        @if ($wd->admin_notes)
                                            <p class="text-xs text-gray-400 mt-0.5">Note: {{ $wd->admin_notes }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs font-bold px-3 py-1 rounded-full
                                    @if($wd->status === 'approved') text-green-700 bg-green-100
                                    @elseif($wd->status === 'rejected') text-red-700 bg-red-100
                                    @else text-amber-700 bg-amber-100 @endif">
                                    {{ ucfirst($wd->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $withdrawals->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <p class="font-semibold text-gray-500">No withdrawal requests yet</p>
                        <p class="text-sm text-gray-400 mt-1">Request a withdrawal above and track it here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
