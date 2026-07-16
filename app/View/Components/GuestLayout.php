<?php

namespace App\View\Components;

use App\Models\Celebrity;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public ?Celebrity $celebrity = null;

    public function render(): View
    {
        return view('layouts.guest');
    }
}
