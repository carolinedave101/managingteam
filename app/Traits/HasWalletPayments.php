<?php

namespace App\Traits;

use App\Models\Celebrity;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\RedirectResponse;

trait HasWalletPayments
{
    protected function processWalletPayment(Celebrity $celebrity, float $amount, ?string $referenceId = null): ?WalletTransaction
    {
        $wallet = Wallet::findOrCreateForUser(auth()->user(), $celebrity);

        if ($wallet->balance < $amount) {
            return null;
        }

        return $wallet->debit(
            amount: $amount,
            description: 'Payment for '.class_basename(static::class),
            referenceType: 'payment',
            referenceId: $referenceId,
            createdBy: auth()->user(),
        );
    }

    protected function redirectForTopUp(Celebrity $celebrity, float $amount): RedirectResponse
    {
        $shortfall = number_format($amount, 2, '.', '');

        $returnUrl = url()->previous();

        session()->put('wallet_pending_return', $returnUrl);
        session()->put('wallet_pending_input', request()->except('_token', 'payment_proof'));

        return redirect()->route('celebrity.wallet', [
            'celebrity' => $celebrity->slug,
            'topup' => $shortfall,
            'return' => $returnUrl,
        ])->with('info', 'Your wallet balance is insufficient. Please top up at least $'.number_format($amount, 2).' to continue.');
    }
}
