<?php

namespace App\Http\Controllers;

use App\Events\ApplicationSubmitted;
use App\Events\NewAdminNotification;
use App\Http\Requests\ApplicationRequest;
use App\Models\Celebrity;
use App\Models\FanApplication;
use App\Models\Message;
use App\Models\User;
use App\Traits\HasWalletPayments;

class ApplicationController extends Controller
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

    public function store(ApplicationRequest $request)
    {
        $user = auth()->user();

        if ($user->application) {
            return back()->with('error', 'You have already submitted an application.');
        }

        $fee = $this->celebrity->config['pricing']['fan_application_fee'] ?? 0;

        if ($request->payment_method === 'wallet') {
            $txn = $this->processWalletPayment($this->celebrity, $fee);
            if (! $txn) {
                return $this->redirectForTopUp($this->celebrity, $fee);
            }
        }

        $proofPath = $request->payment_method === 'wallet' ? 'wallet' : ($request->hasFile('payment_proof') ? $request->file('payment_proof')->store('proofs', 'public') : null);

        $application = FanApplication::create([
            'celebrity_id' => $this->celebrity->id,
            'user_id' => $user->id,
            'bio' => $request->bio,
            'reason' => $request->reason,
            'social_links' => $request->social_links,
            'price' => $fee,
            'payment_method' => $request->payment_method,
            'payment_proof' => $proofPath,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Message::create([
                'celebrity_id' => $this->celebrity->id,
                'sender_id' => $user->id,
                'receiver_id' => $admin->id,
                'reference_type' => 'application',
                'reference_id' => (string) $application->id,
                'subject' => "New Fan Application for {$this->celebrity->name}",
                'content' => "Application received from {$user->name}. Bio: ".substr($request->bio, 0, 100).'...',
            ]);
        }

        safe_event(new ApplicationSubmitted($application));
        safe_event(new NewAdminNotification(
            'new_application',
            "New fan application from {$user->name} for {$this->celebrity->name}",
            $this->celebrity->id,
            url('/admin/fan-applications/'.$application->id.'/edit'),
        ));

        return redirect()->route('celebrity.apply', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Application submitted successfully!');
    }
}
