<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Only redirect guests to admin login if not on parent routes
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('parent/*')) {
                return route('parent.login');
            }
            return route('login');
        });
        // After login, send users to appropriate dashboard
        $middleware->redirectUsersTo(function ($request) {
            if (auth()->guard('parent')->check()) {
                return route('parent.dashboard');
            }
            return route('home');
        });
        $middleware->alias([
            'can.section' => \App\Http\Middleware\EnsureSectionPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
