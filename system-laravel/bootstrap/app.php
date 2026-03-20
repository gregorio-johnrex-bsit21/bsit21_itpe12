<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/supervisor.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->trustProxies(at: '*');    
    $middleware->alias([
        'supervisor' => \App\Http\Middleware\SupervisorMiddleware::class,
        'student' => \App\Http\Middleware\StudentMiddleware::class,
    ]);
})
    
    
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();