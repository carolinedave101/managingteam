<?php

use App\Http\Controllers\Admin\MembershipCardDownloadController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CelebrityPageController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MeetGreetController;
use App\Http\Controllers\MembershipCardController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PrivateMeetupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectLinkController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

$baseDomain = parse_url(config('app.url'), PHP_URL_HOST);

// ──────────────────────────────────────────────
//  Auth routes — main domain (non-domain routes)
// ──────────────────────────────────────────────
require __DIR__.'/auth.php';

// ──────────────────────────────────────────────
//  Celebrity subdomains — Fan portals
//  Auth routes for subdomains are included here
//  so they match before the catch-all below.
// ──────────────────────────────────────────────
Route::domain('{celebrity}.'.$baseDomain)->middleware('fan.isolation')->group(function () {
    // Auth routes on subdomains
    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('celebrity.register');
        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('celebrity.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });
    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('celebrity.logout');
    });

    // GET — page views
    Route::get('/', [CelebrityPageController::class, 'home'])->name('celebrity.home');

    Route::get('/apply', [CelebrityPageController::class, 'apply'])->name('celebrity.apply');
    Route::post('/apply', [ApplicationController::class, 'store'])
        ->middleware('auth')->name('celebrity.apply.store');

    Route::get('/membership', [CelebrityPageController::class, 'membership'])->name('celebrity.membership');
    Route::post('/membership/subscribe', [MembershipController::class, 'subscribe'])
        ->middleware('auth')->name('celebrity.membership.subscribe');
    Route::post('/membership/cancel', [MembershipController::class, 'cancel'])
        ->middleware('auth')->name('celebrity.membership.cancel');

    Route::get('/meet-greet', [CelebrityPageController::class, 'meetGreet'])->name('celebrity.meet-greet');
    Route::post('/meet-greet/purchase', [MeetGreetController::class, 'purchase'])
        ->middleware('auth')->name('celebrity.meet-greet.purchase');

    Route::get('/membership-card', [CelebrityPageController::class, 'membershipCard'])->name('celebrity.membership-card');
    Route::post('/membership-card/order', [MembershipCardController::class, 'order'])
        ->middleware('auth')->name('celebrity.membership-card.order');

    Route::get('/private-meetup', [CelebrityPageController::class, 'privateMeetup'])->name('celebrity.private-meetup');
    Route::post('/private-meetup', [PrivateMeetupController::class, 'store'])
        ->middleware('auth')->name('celebrity.private-meetup.store');

    // Authenticated fan routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [CelebrityPageController::class, 'dashboard'])->name('celebrity.dashboard');
        Route::get('/messages', [MessageController::class, 'index'])->name('celebrity.messages');
        Route::post('/messages', [MessageController::class, 'store'])->name('celebrity.messages.store');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('celebrity.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('celebrity.profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('celebrity.profile.destroy');
        Route::get('/wallet', [WalletController::class, 'index'])->name('celebrity.wallet');
        Route::post('/wallet/top-up', [WalletController::class, 'topUp'])->name('celebrity.wallet.top-up');
        Route::get('/wallet/withdraw', [WithdrawalController::class, 'create'])->name('celebrity.wallet.withdraw');
        Route::post('/wallet/withdraw', [WithdrawalController::class, 'store'])->name('celebrity.wallet.withdraw.store');
        Route::post('/wallet/accounts', [WithdrawalController::class, 'storeAccount'])->name('celebrity.wallet.account.store');
        Route::delete('/wallet/accounts/{account}', [WithdrawalController::class, 'destroyAccount'])->name('celebrity.wallet.account.destroy');
    });

    // Custom pages (must be last — catch-all)
    Route::get('/{pageSlug}', [CelebrityPageController::class, 'customPage'])->name('celebrity.page');
});

// ──────────────────────────────────────────────
//  Main domain — Admin panel + utilities
//  Unrestricted (no domain()) so they work on
//  any local host (localhost, 127.0.0.1, etc.).
//  Subdomain requests are caught by the group
//  above before reaching these.
// ──────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect('/admin');
    }

    return view('pages.landing');
})->name('landing');

Route::post('/redirect', [LandingController::class, 'redirect'])->name('landing.redirect');

// Redirect links (short URLs)
Route::get('/r/{code}', [RedirectLinkController::class, 'redirect'])
    ->name('redirect-link');

// Admin: download membership card PDF
Route::middleware('auth')->group(function () {
    Route::get('/admin/membership-cards/{membershipCard}/download', MembershipCardDownloadController::class)
        ->name('admin.membership-cards.download');
});

// Profile routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// TEMPORARY: add pricing to celebrities missing it (remove after running)
Route::get('/_add-pricing', function () {
    if (request('key') !== hash('sha256', 'add-pricing-managingteam-2026')) abort(403);
    $count = 0;
    $pricingTemplate = [
        'membership_tiers' => [
            ['name' => 'Standard', 'price' => 3000, 'color' => '#C0C0C0', 'benefits' => ['Exclusive community access', 'Monthly newsletter', 'Digital membership card', 'Exclusive fan badge', 'Direct messaging with team']],
            ['name' => 'Premium', 'price' => 5000, 'color' => '#FFD700', 'benefits' => ['Everything in Standard', 'Early access to events', 'Priority messaging', 'Exclusive monthly content', 'Member-only livestreams', 'Priority support']],
            ['name' => 'VIP', 'price' => 10000, 'color' => '#E5E4E2', 'benefits' => ['Everything in Premium', 'Quarterly 1-on-1 video call', 'Signed merchandise', 'Private meetup invitations', 'All-access pass', 'Personalized video message', '24/7 priority support', 'Lifetime status badge']],
        ],
        'pricing' => [
            'fan_application_fee' => 5000,
            'membership_card_fee' => 5000,
            'meet_greet_default_price' => 1000,
            'private_meetup' => [
                ['duration' => 30, 'price' => 5000],
                ['duration' => 60, 'price' => 10000],
            ],
        ],
    ];

    \App\Models\Celebrity::all()->each(function (\App\Models\Celebrity $c) use ($pricingTemplate, &$count) {
        $config = $c->config ?? [];
        $hasPricing = isset($config['pricing']) || isset($config['membership_tiers']);
        if (! $hasPricing) {
            $config = array_merge($config, $pricingTemplate);
            $c->config = $config;
            $c->saveQuietly();
            $count++;
        }
    });

    $total = \App\Models\Celebrity::count();
    $msg = "Added pricing to {$count} celebrities (out of {$total} total). Skipped {$total - $count} already had pricing.";
    \Illuminate\Support\Facades\Log::info($msg);
    return nl2br(e($msg));
});

// Debug: check error log
Route::middleware('auth')->get('/_debug-edit', function () {
    if (! auth()->user()->isAdmin()) abort(403);
    $log = file_get_contents(storage_path('logs/laravel.log'));
    $lines = explode("\n", $log);
    $recent = array_slice($lines, -200);
    return '<pre>'.implode("\n", array_map('e', $recent)).'</pre>';
});




