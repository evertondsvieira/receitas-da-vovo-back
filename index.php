<?php

require 'config/database.php';
require 'router.php'

$path = $_SERVER['PATH_INFO'];

switch ($path) {
    case '/':
        echo 'Hello, world!';
        break;

    case '/users':
        require_once 'routes/userRoutes.php';
        break;

    case '/recipes':
        require_once 'routes/recipeRoutes.php';
        break;

    case '/login':
    case '/register':
    case '/logout':
        require_once 'routes/authRoutes.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
        break;
}
