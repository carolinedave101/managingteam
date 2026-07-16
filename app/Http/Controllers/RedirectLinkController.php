<?php

namespace App\Http\Controllers;

use App\Models\RedirectLink;

class RedirectLinkController extends Controller
{
    public function redirect(string $code)
    {
        $link = RedirectLink::where('code', $code)->where('is_active', true)->firstOrFail();

        $link->incrementClicks();

        return redirect($link->target_url, 302);
    }
}
