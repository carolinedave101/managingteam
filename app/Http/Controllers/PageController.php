<?php

namespace App\Http\Controllers;

use App\Models\MeetGreetEvent;
use App\Models\SystemConfig;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function apply()
    {
        $application = auth()->user()?->application;

        return view('pages.apply', compact('application'));
    }

    public function membership()
    {
        $config = SystemConfig::where('key', 'membership_tiers')->first();
        $tiers = $config ? $config->value : [];
        $activeMembership = auth()->user()?->memberships()->where('is_active', true)->first();

        return view('pages.membership', compact('tiers', 'activeMembership'));
    }

    public function meetGreet()
    {
        $events = MeetGreetEvent::where('is_active', true)->orderBy('date')->get();
        $config = SystemConfig::where('key', 'payment_methods')->first();
        $paymentMethods = $config ? $config->value : [];

        return view('pages.meet-greet', compact('events', 'paymentMethods'));
    }

    public function membershipCard()
    {
        $config = SystemConfig::where('key', 'payment_methods')->first();
        $paymentMethods = $config ? $config->value : [];
        $card = auth()->user()?->membershipCards()->first();

        return view('pages.membership-card', compact('paymentMethods', 'card'));
    }

    public function privateMeetup()
    {
        $config = SystemConfig::where('key', 'payment_methods')->first();
        $paymentMethods = $config ? $config->value : [];

        return view('pages.private-meetup', compact('paymentMethods'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $messages = $user->receivedMessages()->latest()->take(10)->get();
        $membership = $user->memberships()->where('is_active', true)->first();

        return view('pages.dashboard', compact('user', 'messages', 'membership'));
    }
}
