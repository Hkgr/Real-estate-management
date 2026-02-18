<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO,
        );
        // يطبق على كل مسارات الويب (ومنها Filament panel)
      //  $middleware->appendToGroup('web', \App\Http\Middleware\NormalizeDigits::class);

        // إذا بدك كمان على الـ API:
        // $middleware->appendToGroup('api', \App\Http\Middleware\ForceLatinDigits::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
