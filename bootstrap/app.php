<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Retirer Sanctum des middlewares API globaux car nous utilisons notre propre système
        // $middleware->api(prepend: [
        //     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        // ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'api.token.auth' => \App\Http\Middleware\ApiTokenAuth::class,
            'profile.complete' => \App\Http\Middleware\EnsureProfileComplete::class,
            'otp.rate.limit' => \App\Http\Middleware\OtpRateLimiter::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
