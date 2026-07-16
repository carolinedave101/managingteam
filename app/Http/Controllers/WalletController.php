<?php

namespace App\Http\Controllers;

use App\Models\Celebrity;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
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

    public function index(Request $request)
    {
        $user = auth()->user();
        $wallet = Wallet::findOrCreateForUser($user, $this->celebrity);
        $transactions = $wallet->transactions()
            ->with('creator')
            ->completed()
            ->latest()
            ->paginate(20);

        $pendingTopUps = $wallet->transactions()
            ->with('creator')
            ->pending()
            ->where('type', 'credit')
            ->latest()
            ->get();

        $paymentMethods = $this->celebrity->enabledPaymentMethods
            ->reject(fn ($m) => $m->type === 'wallet');

        $topupAmount = $request->query('topup');
        $returnUrl = $request->query('return');

        return view('celebrity.wallet', compact('wallet', 'transactions', 'pendingTopUps', 'paymentMethods', 'topupAmount', 'returnUrl'));
    }

    public function topUp(Request $request)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'string'],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:5120'],
            'return_url' => ['nullable', 'url'],
        ]);

        $user = auth()->user();
        $wallet = Wallet::findOrCreateForUser($user, $this->celebrity);

        $proofPath = $request->file('payment_proof')->store('proofs', 'public');

        $wallet->transactions()->create([
            'type' => 'credit',
            'amount' => $data['amount'],
            'status' => 'pending',
            'description' => 'Top-up via '.$data['payment_method'],
            'reference_type' => 'top_up',
            'reference_id' => $proofPath,
            'created_by' => $user->id,
        ]);

        $returnUrl = $data['return_url'] ?? session()->pull('wallet_pending_return');

        if ($returnUrl) {
            $pendingInput = session()->pull('wallet_pending_input');
            if ($pendingInput) {
                session()->flashInput($pendingInput);
            }

            return redirect($returnUrl)
                ->with('success', 'Your top-up request has been submitted and is pending review. $'.number_format($data['amount'], 2).' will be added once approved.');
        }

        return redirect()->route('celebrity.wallet', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Your top-up request has been submitted and is pending review. $'.number_format($data['amount'], 2).' will be added once approved.');
    }
}
