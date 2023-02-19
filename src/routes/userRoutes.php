<?php

namespace App\Routes;

require_once __DIR__ . '/../controllers/userController.php';

use App\Controllers\UserController;

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['PATH_INFO'] === '/users') {
    $userController->index();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/users\/(\d+)$/', $_SERVER['PATH_INFO'], $matches)) {
    $userController->show($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PATH_INFO'] === '/users') {
    $userController->store();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/users\/(\d+)$/', $_SERVER['PATH_INFO'], $matches)) {
    $userController->update($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/users\/(\d+)$/', $_SERVER['PATH_INFO'], $matches)) {
    $userController->destroy($matches[1]);
}