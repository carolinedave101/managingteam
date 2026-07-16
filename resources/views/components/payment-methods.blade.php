@props([
    'methods',
    'wallet' => null,
    'uniqueId' => 'pm-' . \Illuminate\Support\Str::random(6),
    'selectName' => 'payment_method',
    'proofName' => 'payment_proof',
    'showWallet' => true,
    'label' => 'Payment Method',
    'required' => true,
    'amountLabel' => null,
    'price' => 0,
    'celebrity' => null,
])

@php
    $insufficient = $showWallet && $wallet && $price > 0 && $wallet->balance < $price;
@endphp

<div data-uid="{{ $uniqueId }}">
    <div class="mb-5">
        <x-input-label for="{{ $uniqueId }}-select" :value="$label" />
        @if ($amountLabel)
            <p class="text-xs text-gray-400 mt-0.5">{{ $amountLabel }}</p>
        @endif
        <select name="{{ $selectName }}" id="{{ $uniqueId }}-select" {{ $required ? 'required' : '' }}
                onchange="window.paymentMethodToggle('{{ $uniqueId }}', this.value)"
                class="form-input mt-1">
            @foreach ($methods as $method)
                <option value="{{ $method->type }}" {{ old($selectName, 'bank_transfer') === $method->type ? 'selected' : '' }}>{{ $method->label }}</option>
            @endforeach
            @if ($showWallet && $wallet)
                <option value="wallet" @if ($insufficient) style="color:#dc2626;font-weight:600" @endif>
                    Wallet (${{ number_format($wallet->balance, 2) }})
                    @if ($insufficient) — Top up ${{ number_format($price - $wallet->balance, 2) }} @endif
                </option>
            @endif
        </select>
    </div>

    {{-- Payment proof upload --}}
    <div id="{{ $uniqueId }}-proof" class="hidden mb-6">
        <x-input-label for="{{ $uniqueId }}-proof-input" value="Upload Payment Proof" />
        <input type="file" name="{{ $proofName }}" id="{{ $uniqueId }}-proof-input" accept="image/*,.pdf" {{ $required ? 'required' : '' }}
               class="form-input mt-1 text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 file:cursor-pointer cursor-pointer" />
        <p class="text-xs text-gray-400 mt-1">Screenshot or receipt (image or PDF, max 5MB).</p>
    </div>

    {{-- Wallet info --}}
    <div id="{{ $uniqueId }}-wallet" class="hidden bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-emerald-800 text-sm">Pay with Wallet</p>
                <p class="text-xs text-emerald-600 mt-0.5">Your wallet balance will be deducted immediately. No upload needed.</p>
            </div>
        </div>
    </div>

    {{-- Low balance warning --}}
    @if ($insufficient)
    <div id="{{ $uniqueId }}-low-balance" class="hidden" style="background-color:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:16px;margin-bottom:24px;">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 shrink-0 mt-0.5" style="color:#dc2626" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-semibold text-sm" style="color:#991b1b">Insufficient Balance Please Top Up</p>
                <p class="text-xs mt-1" style="color:#b91c1c">Your wallet balance (${{ number_format($wallet->balance, 2) }}) is not enough. Please top up at least <strong>${{ number_format($price - $wallet->balance, 2) }}</strong> to continue.</p>
                <a href="{{ route('celebrity.wallet', ['celebrity' => $celebrity->slug, 'topup' => number_format($price - $wallet->balance, 2, '.', ''), 'return' => url()->current()]) }}" class="inline-block mt-3 px-5 py-2.5 rounded-xl text-sm font-bold text-white transition" style="background:linear-gradient(135deg,#dc2626,#991b1b);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">Top Up ${{ number_format($price - $wallet->balance, 2) }} Now</a>
            </div>
        </div>
    </div>
    @endif

    {{-- Payment method details --}}
    @foreach ($methods as $pm)
        @php
            $pmType = $pm->type;
            $bgColor = match($pmType) {
                'cryptocurrency' => 'bg-blue-50 border-blue-200 text-blue-700 prose-blue',
                'bank_transfer' => 'bg-indigo-50 border-indigo-200 text-indigo-700 prose-indigo',
                'paypal' => 'bg-sky-50 border-sky-200 text-sky-700 prose-sky',
                'stripe' => 'bg-gray-50 border-gray-200 text-gray-700 prose-gray',
                'offline' => 'bg-purple-50 border-purple-200 text-purple-700 prose-purple',
                default => 'bg-gray-50 border-gray-200 text-gray-700 prose-gray',
            };
            $parts = explode(' ', $bgColor);
            $bg = $parts[0];
            $border = $parts[1];
            $txt = $parts[2];
            $prose = $parts[3];
        @endphp
        <div id="{{ $uniqueId }}-{{ $pmType }}" class="hidden {{ $bg }} border {{ $border }} rounded-xl p-4 mb-6">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @switch($pmType)
                        @case('cryptocurrency')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @break
                        @case('bank_transfer')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            @break
                        @case('paypal')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            @break
                        @default
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @endswitch
                </svg>
                <p class="text-sm font-semibold {{ $txt }}">{{ $pm->label }}</p>
            </div>

            @if ($pmType === 'cryptocurrency')
                @php $qrData = urlencode($pm->details['wallet_address'] ?? ''); @endphp
                @if ($qrData)
                    <div class="flex items-start gap-4 mt-2">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ $qrData }}" alt="QR Code" class="rounded-lg shrink-0" style="width:110px;height:110px" />
                        <div class="text-xs {{ $txt }} space-y-1 flex-1 min-w-0">
                            <p><strong>Network:</strong> {{ ucfirst(str_replace('_', ' ', $pm->details['network'] ?? '')) }}</p>
                            <p class="break-all"><strong>Address:</strong> <code class="{{ $bg }} px-1 rounded {{ $txt }} text-[11px]">{{ $pm->details['wallet_address'] ?? '' }}</code></p>
                            @if (!empty($pm->details['instructions']))
                                <div class="mt-1 {{ $prose }} prose prose-sm">{!! $pm->details['instructions'] !!}</div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="mt-2 text-xs {{ $txt }} space-y-1">
                        <p><strong>Network:</strong> {{ ucfirst(str_replace('_', ' ', $pm->details['network'] ?? '')) }}</p>
                        @if (!empty($pm->details['instructions']))
                            <div class="mt-1 {{ $prose }} prose prose-sm">{!! $pm->details['instructions'] !!}</div>
                        @endif
                    </div>
                @endif
            @elseif ($pmType === 'bank_transfer')
                <div class="mt-2 text-xs {{ $txt }} space-y-1">
                    @if (!empty($pm->details['bank_name']))<p><strong>Bank:</strong> {{ $pm->details['bank_name'] }}</p>@endif
                    @if (!empty($pm->details['account_number']))<p><strong>Account No:</strong> <code class="{{ $bg }} px-1 rounded {{ $txt }}">{{ $pm->details['account_number'] }}</code></p>@endif
                    @if (!empty($pm->details['account_name']))<p><strong>Account Name:</strong> {{ $pm->details['account_name'] }}</p>@endif
                    @if (!empty($pm->details['routing_number']))<p><strong>Routing:</strong> <code class="{{ $bg }} px-1.5 rounded {{ $txt }} font-bold text-xs">{{ $pm->details['routing_number'] }}</code></p>@endif
                    @if (!empty($pm->details['swift_code']))<p><strong>SWIFT:</strong> <code class="{{ $bg }} px-1.5 rounded {{ $txt }} font-bold text-xs">{{ $pm->details['swift_code'] }}</code></p>@endif
                    @if (!empty($pm->details['instructions']))<div class="mt-1 {{ $prose }} prose prose-sm">{!! $pm->details['instructions'] !!}</div>@endif
                </div>
            @elseif ($pmType === 'paypal')
                <div class="mt-2 text-xs {{ $txt }} space-y-1">
                    @if (!empty($pm->details['email']))<p><strong>PayPal Email:</strong> <code class="{{ $bg }} px-1 rounded {{ $txt }}">{{ $pm->details['email'] }}</code></p>@endif
                    @if (!empty($pm->details['instructions']))<div class="mt-1 {{ $prose }} prose prose-sm">{!! $pm->details['instructions'] !!}</div>@endif
                </div>
            @elseif ($pmType === 'offline')
                <div class="mt-2 text-xs {{ $txt }} space-y-1">
                    @if (!empty($pm->details['custom_label']))<p><strong>{{ $pm->details['custom_label'] }}</strong></p>@endif
                    @if (!empty($pm->details['instructions']))<div class="mt-1 {{ $prose }} prose prose-sm">{!! $pm->details['instructions'] !!}</div>@endif
                </div>
            @else
                @if (!empty($pm->details['instructions']))
                    <div class="mt-2 text-xs {{ $txt }} space-y-1">
                        <div class="{{ $prose }} prose prose-sm">{!! $pm->details['instructions'] !!}</div>
                    </div>
                @endif
            @endif
        </div>
    @endforeach

    {{-- Step-by-step payment guide --}}
    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">How to Pay</p>
        </div>
        <ol class="text-xs text-gray-500 space-y-1.5 ml-4 list-decimal">
            <li>Select your preferred payment method from the dropdown above.</li>
            <li>Follow the payment instructions shown for your chosen method.</li>
            <li class="wallet-step hidden" data-uid="{{ $uniqueId }}">If using wallet: click submit — no upload needed.</li>
            <li class="proof-step hidden" data-uid="{{ $uniqueId }}">Upload a screenshot or receipt as proof of payment.</li>
            <li>Click the submit button below to complete your request.</li>
        </ol>
    </div>
</div>

@once
    <script>
        window.paymentMethodToggle = function(uid, val) {
            var proof = document.getElementById(uid + '-proof');
            var wallet = document.getElementById(uid + '-wallet');
            var walletSteps = document.querySelectorAll('.wallet-step[data-uid="' + uid + '"]');
            var proofSteps = document.querySelectorAll('.proof-step[data-uid="' + uid + '"]');

            function show(el, showIt) {
                if (!el) return;
                if (showIt) el.classList.remove('hidden'); else el.classList.add('hidden');
            }

            show(proof, val !== 'wallet');
            show(wallet, val === 'wallet');

            show(document.getElementById(uid + '-low-balance'), val === 'wallet');

            walletSteps.forEach(function(el) { show(el, val === 'wallet'); });
            proofSteps.forEach(function(el) { show(el, val !== 'wallet'); });

            var proofInput = document.getElementById(uid + '-proof-input');
            if (proofInput) proofInput.required = (val !== 'wallet');

            var detailTypes = [];
            document.querySelectorAll('[id^="' + uid + '-"]').forEach(function(el) {
                var suffix = el.id.slice(uid.length + 1);
                if (suffix && suffix !== 'proof' && suffix !== 'wallet' && suffix !== 'select' && suffix !== 'proof-input' && suffix !== 'low-balance') {
                    detailTypes.push(el);
                }
            });

            detailTypes.forEach(function(el) {
                var type = el.id.slice(uid.length + 1);
                show(el, val === type);
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-uid]').forEach(function(container) {
                var uid = container.dataset.uid;
                var select = document.getElementById(uid + '-select');
                if (select) {
                    window.paymentMethodToggle(uid, select.value);
                }
            });
        });
    </script>
@endonce
