<?php

use Slim\App;

return function (App $app) {
    $app->group('/api', function () use ($app) {
        $app->post('/login', '\App\Controllers\AuthController:login');

        $app->group('', function () use ($app) {
            $app->post('/logout', '\App\Controllers\AuthController:logout');
        })->add(new \App\Middleware\JwtMiddleware);
    });
};