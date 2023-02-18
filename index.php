<?php
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Exception\HttpNotFoundException;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Get container
$container = $app->getContainer();

// Set up controllers
$container->set('RecipeController', function ($container) {
    return new RecipeController($container->get('RecipeDAO'));
});

$container->set('UserController', function ($container) {
    return new UserController($container->get('UserDAO'));
});

$container->set('AuthController', function ($container) {
    return new AuthController($container->get('UserDAO'));
});

// Set up middleware
$container->set('JwtMiddleware', function ($container) {
    return new JwtMiddleware($container->get('jwt'));
});

// Set up routes
require __DIR__ . '/../app/routes/authRoutes.php';
require __DIR__ . '/../app/routes/recipeRoutes.php';
require __DIR__ . '/../app/routes/userRoutes.php';

// Add route not found handler
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$app->run();