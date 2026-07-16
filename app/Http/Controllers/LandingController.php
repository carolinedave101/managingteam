<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function redirect(Request $request)
    {
        $link = $request->input('celebrity_link');

        if (! $link) {
            return back()->withErrors(['celebrity_link' => 'Please enter a Celebrity Management link.']);
        }

        $link = trim($link);

        // Strip protocol and path
        $link = preg_replace('#^https?://#', '', $link);
        $link = preg_replace('#/.*$#', '', $link);

        // Extract slug from "slug.managingteam.info" or just "slug"
        $parts = explode('.', $link);
        $slug = $parts[0];

        if (! $slug) {
            return back()->withErrors(['celebrity_link' => 'Invalid link format.']);
        }

        $url = parse_url(config('app.url'));
        $host = $url['host'] ?? 'localhost';
        $scheme = $url['scheme'] ?? 'http';
        $port = $url['port'] ?? null;

        if (app()->environment('local')) {
            $port = $port ?: 8000;

            return redirect("{$scheme}://{$slug}.{$host}:{$port}");
        }

        if ($port) {
            return redirect("{$scheme}://{$slug}.{$host}:{$port}");
        }

        return redirect("{$scheme}://{$slug}.{$host}");
    }
}
