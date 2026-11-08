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
        $middleware->alias([
            'master' => \App\Http\Middleware\MasterMiddleware::class,
            'voice_donor_restrict' => \App\Http\Middleware\VoiceDonorRestrictionMiddleware::class,
            'auth.home' => \App\Http\Middleware\RedirectNonAuthenticatedToHome::class,
            'check.reglement' => \App\Http\Middleware\CheckReglementAccepted::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
