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

        // middleware globali
        $middleware->appendToGroup('web', [ 
            \App\Http\Middleware\LangStatus::class, 
            \App\Http\Middleware\SessionStatus::class
        ]);
    
        $middleware->alias ([
            'PredictionStatus' => \App\Http\Middleware\PredictionStatus::class, 
            'AdminMiddleware' => \App\Http\Middleware\AdminMiddleware::class,
            'UserMiddleware' => \App\Http\Middleware\UserMiddleware::class,
        ]);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
