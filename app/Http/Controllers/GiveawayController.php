<?php

namespace App\Http\Controllers;

use App\Events\GiveawayEntered;
use App\Models\Celebrity;
use App\Models\Giveaway;
use App\Models\Wallet;
use App\Traits\HasWalletPayments;
use Illuminate\Support\Facades\Auth;

class GiveawayController extends Controller
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

    public function enter()
    {
        $giveawayId = request()->route('giveaway');
        $giveaway = Giveaway::findOrFail($giveawayId);
        if ($giveaway->celebrity_id !== $this->celebrity->id) {
            abort(404);
        }

        if ($giveaway->fan_id && $giveaway->fan_id !== Auth::id()) {
            abort(404);
        }

        if (!$giveaway->isActive()) {
            return back()->with('error', 'This giveaway is not currently active.');
        }

        $user = Auth::user();
        $currentEntries = $giveaway->getEntryCountForUser($user->id);

        if ($currentEntries >= $giveaway->max_entries_per_fan) {
            return back()->with('error', 'You have already reached the maximum number of entries for this giveaway.');
        }

        $nextNumber = $giveaway->entries()->max('entry_number') + 1;

        $paymentMethod = null;
        $paymentProof = null;
        $heartfeltNote = null;

        if (!$giveaway->isFree()) {
            request()->validate([
                'payment_method' => 'required|string',
                'payment_proof' => 'required_if:payment_method,bank_transfer,cryptocurrency,paypal,offline|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);

            $paymentMethod = request('payment_method');

            if (request()->hasFile('payment_proof')) {
                $paymentProof = request()->file('payment_proof')->store('payment-proofs', 'public');
            }

            if ($paymentMethod === 'wallet') {
                $wallet = Wallet::findOrCreateForUser($user, $this->celebrity);
                if ($wallet->balance < $giveaway->entry_fee) {
                    return $this->redirectForTopUp($this->celebrity, $giveaway->entry_fee);
                }
                $wallet->debit(
                    (float) $giveaway->entry_fee,
                    "Entry fee for \"{$giveaway->title}\" giveaway",
                    'giveaway',
                    (string) $giveaway->id,
                    $user,
                );
            }
        }

        request()->validate([
            'heartfelt_note' => 'nullable|string|max:500',
        ]);

        $heartfeltNote = request('heartfelt_note');

        $entry = $giveaway->entries()->create([
            'user_id' => $user->id,
            'celebrity_id' => $this->celebrity->id,
            'entry_number' => $nextNumber,
            'status' => 'entered',
            'payment_method' => $paymentMethod,
            'payment_proof' => $paymentProof,
            'heartfelt_note' => $heartfeltNote,
        ]);

        event(new GiveawayEntered($entry));

        $entryId = $entry->entry_number;

        return back()->with('success', "You have successfully entered the giveaway! Your entry number is #{$entryId}. Good luck!");
    }
}
