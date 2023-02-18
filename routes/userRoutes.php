<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Controllers\UserController;
use App\Middlewares\JwtMiddleware;

return function (App $app) {

    $app->group('/api/v1/users', function() use ($app) {

        $app->get('', function (Request $request, Response $response, array $args) {
            $controller = new UserController($request, $response, $args);
            return $controller->index();
        })->add(new JwtMiddleware);

        $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $controller = new UserController($request, $response, $args);
            return $controller->show();
        })->add(new JwtMiddleware);

        $app->post('', function (Request $request, Response $response, array $args) {
            $controller = new UserController($request, $response, $args);
            return $controller->create();
        });

        $app->put('/{id}', function (Request $request, Response $response, array $args) {
            $controller = new UserController($request, $response, $args);
            return $controller->update();
        })->add(new JwtMiddleware);

        $app->delete('/{id}', function (Request $request, Response $response, array $args) {
            $controller = new UserController($request, $response, $args);
            return $controller->delete();
        })->add(new JwtMiddleware);

    });

};