<?php

namespace App\Http\Controllers;

use App\Events\MeetGreetBooked;
use App\Events\NewAdminNotification;
use App\Models\Celebrity;
use App\Models\MeetGreetEvent;
use App\Models\MeetGreetTicket;
use App\Traits\HasWalletPayments;

class MeetGreetController extends Controller
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

    public function events()
    {
        return MeetGreetEvent::where('celebrity_id', $this->celebrity->id)
            ->where('is_active', true)
            ->orderBy('date')
            ->get();
    }

    public function purchase()
    {
        request()->validate([
            'event_id' => 'required|exists:meet_greet_events,id',
            'quantity' => 'required|integer|min:1|max:10',
            'payment_method' => 'required|string',
            'payment_proof' => 'required_if:payment_method,!=,wallet|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:5120',
        ]);

        $event = MeetGreetEvent::where('celebrity_id', $this->celebrity->id)
            ->findOrFail(request('event_id'));
        $totalPrice = $event->price * request('quantity');

        if (request('payment_method') === 'wallet') {
            $txn = $this->processWalletPayment($this->celebrity, $totalPrice);
            if (! $txn) {
                return $this->redirectForTopUp($this->celebrity, $totalPrice);
            }
        }

        $proofPath = request('payment_method') === 'wallet' ? 'wallet' : request()->file('payment_proof')->store('proofs', 'public');

        $ticket = MeetGreetTicket::create([
            'celebrity_id' => $this->celebrity->id,
            'user_id' => auth()->id(),
            'event_id' => request('event_id'),
            'quantity' => request('quantity'),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_method' => request('payment_method'),
            'payment_proof' => $proofPath,
        ]);

        safe_event(new MeetGreetBooked($ticket));
        safe_event(new NewAdminNotification(
            'new_meetgreet',
            "New ticket purchase for {$event->title} by ".auth()->user()->name,
            $this->celebrity->id,
            url('/admin/meet-greet-tickets/'.$ticket->id.'/edit'),
        ));

        return redirect()->route('celebrity.meet-greet', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Ticket purchase submitted!');
    }
}
