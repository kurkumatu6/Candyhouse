<?php
use app\models\Category;
use app\models\Ingredient;
use app\models\IngredientsCategory;

session_start();

require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
$title = "Конструктор";
$categories = Category::getAllCatehories();
$ingredients = Ingredient::getAllIngredients();
$ingredientsCategorys = IngredientsCategory::getAllIngrCategory();
$ingredientsByCategory = [];
foreach($ingredients as $ingredient){
    $ingredientsByCategory[$ingredient->category] =[];

}
foreach($ingredients as $ingredient){
    array_push($ingredientsByCategory[$ingredient->category],$ingredient);
}     
// var_dump($ingredientsByCategory);
require_once $_SERVER["DOCUMENT_ROOT"]. "/views/tables/recipes/construct.view.php";
unset($_SESSION["error"]);