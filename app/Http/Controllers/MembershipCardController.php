<?php

namespace App\Http\Controllers;

use App\Events\CardOrdered;
use App\Events\NewAdminNotification;
use App\Models\Celebrity;
use App\Models\MembershipCard;
use App\Traits\HasWalletPayments;

class MembershipCardController extends Controller
{
    use HasWalletPayments;

    protected Celebrity $celebrity;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $slug = $request->route('celebrity');
            $this->celebrity = Celebrity::where('slug', $slug)->firstOrFail();
            view()->share('celebrity', $this->celebrity);

            return $next($request);
        });
    }

    public function order()
    {
        request()->validate([
            'tier' => 'required|string',
            'payment_method' => 'required|string',
            'payment_proof' => 'required_if:payment_method,!=,wallet|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:5120',
        ]);

        $user = auth()->user();

        if ($user->membershipCards()->where('celebrity_id', $this->celebrity->id)->exists()) {
            return back()->with('error', 'You already have a membership card.');
        }

        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $this->celebrity->name), 0, 2)) ?: 'JK';
        $cardNumber = $prefix.'-'.implode('-', [
            str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
            str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
            str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
            str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
        ]);

        $cardFee = $this->celebrity->config['pricing']['membership_card_fee'] ?? 0;

        if (request('payment_method') === 'wallet') {
            $txn = $this->processWalletPayment($this->celebrity, $cardFee);
            if (! $txn) {
                return $this->redirectForTopUp($this->celebrity, $cardFee);
            }
        }

        $proofPath = request('payment_method') === 'wallet' ? 'wallet' : request()->file('payment_proof')->store('proofs', 'public');

        $card = MembershipCard::create([
            'celebrity_id' => $this->celebrity->id,
            'user_id' => $user->id,
            'card_number' => $cardNumber,
            'tier' => request('tier'),
            'price' => $cardFee,
            'is_active' => false,
            'payment_method' => request('payment_method'),
            'payment_proof' => $proofPath,
        ]);

        safe_event(new CardOrdered($card));
        safe_event(new NewAdminNotification(
            'new_card',
            "New membership card order from {$user->name} for {$this->celebrity->name} ({$card->tier})",
            $this->celebrity->id,
            url('/admin/membership-cards/'.$card->id.'/edit'),
        ));

        return redirect()->route('celebrity.membership-card', ['celebrity' => $this->celebrity->slug])
            ->with('success', "Card ordered! Number: {$cardNumber}");
    }
}
