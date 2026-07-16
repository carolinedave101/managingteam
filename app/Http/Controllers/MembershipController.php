<?php

namespace App\Http\Controllers;

use App\Events\MembershipUpdated;
use App\Events\NewAdminNotification;
use App\Models\Celebrity;
use App\Models\Membership;
use App\Traits\HasWalletPayments;

class MembershipController extends Controller
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

    public function subscribe()
    {
        request()->validate([
            'tier' => 'required|string',
            'price' => 'required|numeric',
            'payment_method' => 'required|string',
            'payment_proof' => 'required_if:payment_method,!=,wallet|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:5120',
        ]);

        $user = auth()->user();

        $existing = Membership::where('user_id', $user->id)
            ->where('celebrity_id', $this->celebrity->id)
            ->where('is_active', true)
            ->first();
        if ($existing) {
            return back()->with('error', 'You already have an active membership.');
        }

        if (request('payment_method') === 'wallet') {
            $txn = $this->processWalletPayment($this->celebrity, (float) request('price'));
            if (! $txn) {
                return $this->redirectForTopUp($this->celebrity, (float) request('price'));
            }
        }

        $proofPath = request('payment_method') === 'wallet' ? 'wallet' : request()->file('payment_proof')->store('proofs', 'public');

        $membership = Membership::create([
            'celebrity_id' => $this->celebrity->id,
            'user_id' => $user->id,
            'tier' => request('tier'),
            'price' => request('price'),
            'is_active' => false,
            'payment_method' => request('payment_method'),
            'payment_proof' => $proofPath,
        ]);

        safe_event(new MembershipUpdated($membership));
        safe_event(new NewAdminNotification(
            'new_membership',
            "New membership request from {$user->name} for {$this->celebrity->name} ({$membership->tier})",
            $this->celebrity->id,
            url('/admin/memberships/'.$membership->id.'/edit'),
        ));

        return redirect()->route('celebrity.membership', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Membership request submitted!');
    }

    public function cancel()
    {
        $membership = Membership::where('user_id', auth()->id())
            ->where('celebrity_id', $this->celebrity->id)
            ->where('is_active', true)
            ->firstOrFail();

        $membership->update(['is_active' => false, 'end_date' => now()]);

        safe_event(new MembershipUpdated($membership));

        return redirect()->route('celebrity.membership', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Membership cancelled.');
    }
}
