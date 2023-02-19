<?php
require 'vendor/autoload.php';
require 'config/database.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER["REQUEST_URI"];

$routes = [
    ['/', 'home'],
    ['/users', 'user'],
    ['/recipes', 'recipe'],
    ['/auth', 'auth']
];

foreach ($routes as $route) {
    if (preg_match("#^$route[0]$#", $requestUri, $matches)) {
        $controllerName = ucfirst($route[1]) . "Controller";
        require "classes/$controllerName.php";
        $controller = new $controllerName();

        switch ($requestMethod) {
            case 'GET':
                $controller->index();
                break;
            case 'POST':
                $controller->create();
                break;
            case 'PUT':
                $controller->update();
                break;
            case 'DELETE':
                $controller->delete();
                break;
        }
        break;
    }
}

if (!isset($controller)) {
    http_response_code(404);
    echo "Endpoint não encontrado.";
}
