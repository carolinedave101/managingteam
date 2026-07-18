<?php

namespace App\Http\Controllers;

use App\Events\WithdrawalRequested;
use App\Models\Celebrity;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Models\WithdrawalAccount;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
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

    public function create()
    {
        $user = auth()->user();
        $wallet = Wallet::findOrCreateForUser($user, $this->celebrity);
        $accounts = WithdrawalAccount::where('user_id', $user->id)
            ->where('celebrity_id', $this->celebrity->id)
            ->get();
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->where('celebrity_id', $this->celebrity->id)
            ->with('withdrawalAccount')
            ->latest()
            ->paginate(20);

        return view('celebrity.withdraw', compact('wallet', 'accounts', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'withdrawal_account_id' => ['required', 'exists:withdrawal_accounts,id'],
        ]);

        $user = auth()->user();
        $wallet = Wallet::findOrCreateForUser($user, $this->celebrity);

        $account = WithdrawalAccount::where('id', $data['withdrawal_account_id'])
            ->where('user_id', $user->id)
            ->where('celebrity_id', $this->celebrity->id)
            ->firstOrFail();

        if ($wallet->balance < $data['amount']) {
            return back()->withErrors(['amount' => 'Insufficient wallet balance. You have $'.number_format($wallet->balance, 2).'.']);
        }

        $withdrawal = $wallet->withdrawals()->create([
            'user_id' => $user->id,
            'celebrity_id' => $this->celebrity->id,
            'withdrawal_account_id' => $account->id,
            'amount' => $data['amount'],
            'status' => 'pending',
        ]);

        safe_event(new WithdrawalRequested($withdrawal));

        return redirect()->route('celebrity.wallet.withdraw', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Your withdrawal request for $'.number_format($data['amount'], 2).' has been submitted and is pending review by the '.$this->celebrity->name.' Management Team.');
    }

    public function storeAccount(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'in:bank,cashapp,paypal,cryptocurrency'],
            'label' => ['required', 'string', 'max:255'],
            'details' => ['required', 'array'],
        ]);

        $user = auth()->user();

        $detailRules = [
            'bank' => ['bank_name' => 'required|string', 'account_name' => 'required|string', 'account_number' => 'required|string', 'routing_number' => 'nullable|string', 'swift_code' => 'nullable|string'],
            'cashapp' => ['cashtag' => 'required|string'],
            'paypal' => ['email' => 'required|email'],
            'cryptocurrency' => ['network' => 'required|string', 'wallet_address' => 'required|string'],
        ];

        $rules = $detailRules[$data['type']] ?? [];
        $validatedDetails = validator($data['details'], $rules)->validate();

        $account = WithdrawalAccount::create([
            'user_id' => $user->id,
            'celebrity_id' => $this->celebrity->id,
            'type' => $data['type'],
            'label' => $data['label'],
            'details' => $validatedDetails,
        ]);

        if (! WithdrawalAccount::where('user_id', $user->id)->where('celebrity_id', $this->celebrity->id)->where('is_default', true)->exists()) {
            $account->update(['is_default' => true]);
        }

        return redirect()->route('celebrity.wallet.withdraw', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Your '.$data['type'].' account has been saved.');
    }

    public function destroyAccount($id)
    {
        $user = auth()->user();
        $account = WithdrawalAccount::where('id', $id)
            ->where('user_id', $user->id)
            ->where('celebrity_id', $this->celebrity->id)
            ->firstOrFail();

        $account->delete();

        return redirect()->route('celebrity.wallet.withdraw', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Account removed.');
    }
}
