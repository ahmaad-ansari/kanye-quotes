<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\PasswordProtection;
use App\Http\Middleware\ApiTokenAuth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'api.token' => ApiTokenAuth::class, // Secure API routes with token authentication
            'password.protection' => PasswordProtection::class, // Secure the password-protected routes
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
