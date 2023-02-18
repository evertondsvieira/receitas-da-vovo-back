<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $app->get('/recipes', '\App\Controllers\RecipeController:getAllRecipes');
    $app->get('/recipes/{id}', '\App\Controllers\RecipeController:getRecipe');
    $app->post('/recipes', '\App\Controllers\RecipeController:createRecipe');
    $app->put('/recipes/{id}', '\App\Controllers\RecipeController:updateRecipe');
    $app->delete('/recipes/{id}', '\App\Controllers\RecipeController:deleteRecipe');
};