<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $celebrity = $this->resolveCelebrityFromHost(request());

        return view('auth.register', compact('celebrity'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'fan',
        ]);

        $celebrity = $this->resolveCelebrityFromHost($request);
        if ($celebrity) {
            $user->celebrities()->attach($celebrity->id, ['status' => 'active']);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($celebrity) {
            return redirect()->route('celebrity.dashboard', ['celebrity' => $celebrity->slug]);
        }

        return redirect('/');
    }

    private function resolveCelebrityFromHost(Request $request): ?Celebrity
    {
        $host = $request->getHost();
        $baseDomain = parse_url(config('app.url'), PHP_URL_HOST);

        if (preg_match('/^([a-z0-9-]+)\.'.preg_quote($baseDomain).'$/i', $host, $matches)) {
            return Celebrity::where('slug', $matches[1])->where('is_active', true)->first();
        }

        return null;
    }
}
