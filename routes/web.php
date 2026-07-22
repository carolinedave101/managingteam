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
use App\Models\Celebrity;
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

Route::get('/celebrities', function () {
    $celebrities = Celebrity::where('is_active', true)
        ->orderBy('category')
        ->orderBy('name')
        ->get();

    return view('pages.celebrities', compact('celebrities'));
})->name('celebrities.index');

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

// Debug: check error log
