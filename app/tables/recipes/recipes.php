<?php

use app\models\Ingredient;
use app\models\Recipe;
use app\models\IngredientsInRecipes;
use app\models\RecipesDiscriptions;
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
$recipes = Recipe::getAllUserRecipes($_SESSION["user"]["id"]);
$ingredientsInRecipes = [];
$discriptionsInRecipes = [];
$UserIngredientstemp =[];
$firstChars = [];
$UserIngredients = [];
foreach($recipes as $recipe){
    $ingredientsInRecipes[$recipe->id] = IngredientsInRecipes::getAllIngredientsInRecipe($recipe->id);
}
$title = "Мои рецепты";
foreach($recipes as $recipe){
    $discriptionsInRecipes[$recipe->id] = RecipesDiscriptions::getAllDescriptionInRecipe($recipe->id);
}
foreach(Ingredient::getAllIngredients() as  $ingr){
    if(Ingredient::getIngredientInUserRecipes($_SESSION["user"]["id"], $ingr->id) != null){
        array_push( $UserIngredientstemp,Ingredient::getIngredientInUserRecipes($_SESSION["user"]["id"], $ingr->id));
    }
}
foreach($UserIngredientstemp as $ingr){
    if( !in_array(mb_substr( $ingr->name,0,1), $firstChars)){
        array_push($firstChars,mb_substr( $ingr->name,0,1));
    }
}
foreach ($firstChars as $char){
    $UserIngredients[$char]= [];
}
foreach($UserIngredientstemp as $item){
    array_push($UserIngredients[mb_substr( $item->name,0,1)], $item);

}
// var_dump($recipes);
// var_dump($discriptionsInRecipes);
// var_dump($firstChars);
// foreach ($recipes as $recipe) {
//     var_dump(count( $discriptionsInRecipes[$recipe->id]) >= 2);
// }
// var_dump($UserIngredients);
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/tables/recipes/recipes.view.php"; ?>

