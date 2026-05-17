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
    ->withMiddleware(function (Middleware $middleware): void {
        // 1. Logika alias middleware yang sudah ada (Tetap dipertahankan)
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        // 2. SINKRONISASI: Mengecualikan Route Midtrans dari CSRF sesuai dengan routes/web.php
        $middleware->validateCsrfTokens(except: [
            'api/midtrans-callback', // Diubah agar sinkron dengan rute baru
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();