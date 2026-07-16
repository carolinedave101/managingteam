<?php

namespace App\Http\Controllers;

use App\Models\Celebrity;
use App\Models\FanApplication;
use App\Models\MeetGreetEvent;
use App\Models\Wallet;

class CelebrityPageController extends Controller
{
    protected Celebrity $celebrity;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $slug = $request->route('celebrity');
            $this->celebrity = Celebrity::where('slug', $slug)->firstOrFail();
            view()->share('celebrity', $this->celebrity);

            return $next($request);
        });
    }

    public function home()
    {
        return view('celebrity.home');
    }

    public function apply()
    {
        $application = auth()->user()?->application;

        return view('celebrity.apply', compact('application'));
    }

    public function membership()
    {
        $config = $this->celebrity->config;
        $tiers = $config['membership_tiers'] ?? [];
        $paymentMethods = $this->celebrity->enabledPaymentMethods;
        $activeMembership = null;
        if (auth()->check()) {
            $activeMembership = auth()->user()->memberships()
                ->where('celebrity_id', $this->celebrity->id)
                ->where('is_active', true)
                ->first();
        }

        return view('celebrity.membership', compact('tiers', 'paymentMethods', 'activeMembership'));
    }

    public function meetGreet()
    {
        $events = MeetGreetEvent::where('celebrity_id', $this->celebrity->id)
            ->where('is_active', true)
            ->orderBy('date')
            ->get();
        $paymentMethods = $this->celebrity->enabledPaymentMethods;

        return view('celebrity.meet-greet', compact('events', 'paymentMethods'));
    }

    public function membershipCard()
    {
        $paymentMethods = $this->celebrity->enabledPaymentMethods;
        $card = null;
        if (auth()->check()) {
            $card = auth()->user()->membershipCards()
                ->where('celebrity_id', $this->celebrity->id)
                ->first();
        }

        return view('celebrity.membership-card', compact('paymentMethods', 'card'));
    }

    public function privateMeetup()
    {
        $paymentMethods = $this->celebrity->enabledPaymentMethods;

        return view('celebrity.private-meetup', compact('paymentMethods'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $config = $this->celebrity->config;
        $features = $config['features'] ?? [];
        $pricing = $config['pricing'] ?? [];

        $messages = $user->receivedMessages()
            ->where('celebrity_id', $this->celebrity->id)
            ->latest()
            ->take(5)
            ->get();
        $unreadCount = $user->receivedMessages()
            ->where('celebrity_id', $this->celebrity->id)
            ->where('is_read', false)
            ->count();

        $membership = $user->memberships()
            ->where('celebrity_id', $this->celebrity->id)
            ->where('is_active', true)
            ->first();

        $application = FanApplication::where('user_id', $user->id)
            ->where('celebrity_id', $this->celebrity->id)
            ->first();

        $card = $user->membershipCards()
            ->where('celebrity_id', $this->celebrity->id)
            ->first();

        $tickets = $user->meetGreetTickets()
            ->where('celebrity_id', $this->celebrity->id)
            ->latest()
            ->get();

        $meetups = $user->privateMeetups()
            ->where('celebrity_id', $this->celebrity->id)
            ->latest()
            ->get();

        $upcomingEvents = MeetGreetEvent::where('celebrity_id', $this->celebrity->id)
            ->where('is_active', true)
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(3)
            ->get();

        $wallet = Wallet::findOrCreateForUser($user, $this->celebrity);

        return view('celebrity.dashboard', compact(
            'user', 'messages', 'unreadCount', 'membership',
            'application', 'card', 'tickets', 'meetups',
            'upcomingEvents', 'features', 'pricing', 'wallet'
        ));
    }

    public function customPage(string $pageSlug)
    {
        $page = $this->celebrity->pages()
            ->where('slug', $pageSlug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('celebrity.custom-page', compact('page'));
    }
}
