<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FanIsolationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user->isAdmin()) {
            return $next($request);
        }

        $celebrity = $this->resolveCelebrity($request);

        if ($celebrity) {
            $belongsTo = $user->celebrities()
                ->where('celebrity_id', $celebrity->id)
                ->exists();

            if (!$belongsTo) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect(config('app.url'))
                    ->with('error', 'You are not a member of this celebrity\'s community. Please visit your own celebrity portal.');
            }
        }

        return $next($request);
    }

    private function resolveCelebrity(Request $request): ?\App\Models\Celebrity
    {
        $slug = $request->route('celebrity');

        if ($slug) {
            return \App\Models\Celebrity::where('slug', $slug)->first();
        }

        return null;
    }
}
