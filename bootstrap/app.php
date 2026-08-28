<?php

use App\Http\Middleware\FanIsolationMiddleware;
use App\Models\Celebrity;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withEvents(discover: [
        __DIR__.'/../app/Listeners',
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'fan.isolation' => FanIsolationMiddleware::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            $slug = explode('.', $request->getHost())[0] ?? null;
            if ($slug && Celebrity::where('slug', $slug)->exists()) {
                return route('celebrity.login', ['celebrity' => $slug]);
            }

            return route('landing');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
