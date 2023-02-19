<?php
require_once('../config/database.php');
require_once('../classes/recipe.php');

class RecipeController {
    private $db;
    private $recipe;

    public function __construct() {
        $this->db = new Database();
        $this->recipe = new Recipe($this->db);
    }

    public function createRecipe($data) {
        $this->recipe->name = $data['name'];
        $this->recipe->ingredients = $data['ingredients'];
        $this->recipe->instructions = $data['instructions'];

        if ($this->recipe->create()) {
            return ['status' => true, 'message' => 'Recipe created successfully.'];
        } else {
            return ['status' => false, 'message' => 'Unable to create recipe. Please try again.'];
        }
    }

    public function getRecipeById($id) {
        $this->recipe->id = $id;
        $result = $this->recipe->getById();
        if ($result) {
            return ['status' => true, 'recipe' => $result];
        } else {
            return ['status' => false, 'message' => 'Recipe not found.'];
        }
    }

    public function getAllRecipes() {
        $result = $this->recipe->getAll();
        if ($result) {
            return ['status' => true, 'recipes' => $result];
        } else {
            return ['status' => false, 'message' => 'No recipes found.'];
        }
    }

    public function updateRecipe($id, $data) {
        $this->recipe->id = $id;
        $this->recipe->name = $data['name'];
        $this->recipe->ingredients = $data['ingredients'];
        $this->recipe->instructions = $data['instructions'];

        if ($this->recipe->update()) {
            return ['status' => true, 'message' => 'Recipe updated successfully.'];
        } else {
            return ['status' => false, 'message' => 'Unable to update recipe. Please try again.'];
        }
    }

    public function deleteRecipe($id) {
        $this->recipe->id = $id;

        if ($this->recipe->delete()) {
            return ['status' => true, 'message' => 'Recipe deleted successfully.'];
        } else {
            return ['status' => false, 'message' => 'Unable to delete recipe. Please try again.'];
        }
    }
}
