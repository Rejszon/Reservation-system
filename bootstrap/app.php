<?php

use App\Http\Middleware\ActivePageMiddleware;
use App\Http\Middleware\CurrentUserNameMiddleware;
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
        $middleware->appendToGroup('main-group', [
            ActivePageMiddleware::class,
            CurrentUserNameMiddleware::class,
        ]);
        $middleware->appendToGroup('panel-group', [
            ActivePageMiddleware::class,
            CurrentUserNameMiddleware::class,
        ]);
        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo('/profile');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
