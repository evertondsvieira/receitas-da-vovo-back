<?php

$routes = [
    '/users' => 'user.php',
    '/recipes' => 'recipe.php',
    '/auth' => 'auth.php'
];

if (array_key_exists($_SERVER['REQUEST_URI'], $routes)) {
    require __DIR__ . '/' . $routes[$_SERVER['REQUEST_URI']];
} else {
    http_response_code(404);
    echo "Endpoint não encontrado.";
}