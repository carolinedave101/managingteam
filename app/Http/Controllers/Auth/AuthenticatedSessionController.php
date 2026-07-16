<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Celebrity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $celebrity = $this->resolveCelebrityFromHost(request());

        return view('auth.login', compact('celebrity'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->intended('/admin');
        }

        $celebrity = $this->resolveCelebrityFromHost($request);

        if ($celebrity) {
            return redirect()->intended(route('celebrity.dashboard', ['celebrity' => $celebrity->slug]));
        }

        $fanCelebrity = $user->celebrities()->first();
        if ($fanCelebrity) {
            return redirect()->intended(route('celebrity.dashboard', ['celebrity' => $fanCelebrity->slug]));
        }

        return redirect()->intended('/admin');
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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
