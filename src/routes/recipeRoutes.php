<?php

require_once 'classes/RecipeController.php';

$recipeController = new RecipeController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['PATH_INFO'] === '/recipes') {
    $recipeController->index();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/recipes\/(\d+)$/', $_SERVER['PATH_INFO'], $matches)) {
    $recipeController->show($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PATH_INFO'] === '/recipes') {
    $recipeController->store();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/recipes\/(\d+)$/', $_SERVER['PATH_INFO'], $matches)) {
    $recipeController->update($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/recipes\/(\d+)$/', $_SERVER['PATH_INFO'], $matches)) {
    $recipeController->destroy($matches[1]);
}