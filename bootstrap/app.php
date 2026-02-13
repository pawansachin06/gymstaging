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
        // Register your custom Route Middleware (formerly $routeMiddleware)
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'sweetalert' => \RealRashid\SweetAlert\ToSweetAlert::class, // Updated to new package
        ]);

        // Append to the 'web' group (formerly $middlewareGroups['web'])
        $middleware->web(append: [
            \RealRashid\SweetAlert\ToSweetAlert::class,
        ]);

        // Global Middleware configuration
        // Laravel 12 handles TrimStrings and ConvertEmptyStringsToNull automatically.
        // TrustProxies is also handled natively now.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // You can handle Sentry or custom exceptions here later
    })->create();
