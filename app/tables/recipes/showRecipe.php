<?php
use app\models\IngredientsInRecipes;
use app\models\Recipe;
use app\models\RecipesDiscriptions;
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
if(isset($_GET["id"])){
    $recipe = Recipe::getRecipeById($_GET["id"]);
    $recipeIngredients = IngredientsInRecipes::getAllIngredientsInRecipe($_GET["id"]);
    $steps = RecipesDiscriptions::getAllDescriptionInRecipe($_GET["id"]);
}
else{
    header("Location: /");
}
$title = "Рецепт";
// var_dump($recipe);
// var_dump($recipeIngredients);
// var_dump($steps);
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/tables/recipes/showRecipes.view.php"; ?>