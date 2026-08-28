<?php

namespace App\Http\Controllers;

use App\Events\NewAdminNotification;
use App\Events\PrivateMeetupBooked;
use App\Http\Requests\PrivateMeetupRequest;
use App\Models\Celebrity;
use App\Models\PrivateMeetup;
use App\Traits\HasWalletPayments;

class PrivateMeetupController extends Controller
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

    public function store(PrivateMeetupRequest $request)
    {
        $pricing = $this->celebrity->config['pricing'] ?? [];
        $mode = $pricing['private_meetup_mode'] ?? 'duration';

        if ($mode === 'fixed') {
            $price = (float) ($pricing['private_meetup_fixed'] ?? 0);
            $duration = null;
        } else {
            $meetupPricing = $pricing['private_meetup'] ?? [];
            $price = collect($meetupPricing)->firstWhere('duration', (int) $request->duration)['price'] ?? 0;
            $duration = $request->duration;
        }

        if ($request->payment_method === 'wallet') {
            $txn = $this->processWalletPayment($this->celebrity, $price);
            if (! $txn) {
                return $this->redirectForTopUp($this->celebrity, $price);
            }
        }

        $proofPath = $request->payment_method === 'wallet' ? 'wallet' : ($request->hasFile('payment_proof') ? $request->file('payment_proof')->store('proofs', 'public') : null);

        $meetup = PrivateMeetup::create([
            'celebrity_id' => $this->celebrity->id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'duration' => $duration,
            'location' => $request->location,
            'price' => $price,
            'notes' => $request->notes,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_proof' => $proofPath,
        ]);

        safe_event(new PrivateMeetupBooked($meetup));
        safe_event(new NewAdminNotification(
            'new_private_meetup',
            'New private meetup request from '.auth()->user()->name." for {$this->celebrity->name}",
            $this->celebrity->id,
            url('/admin/private-meetups/'.$meetup->id.'/edit'),
        ));

        return redirect()->route('celebrity.private-meetup', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Private meetup booked!');
    }
}
