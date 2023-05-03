<?php

session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";
use app\models\Recipe;
use app\models\Basket;
use app\models\Ingredient;
use app\models\IngredientsInRecipes;
use app\models\RecipesDiscriptions;
// var_dump($_FILES);
if(isset($_POST["delRecipeConfirm"])){
    Recipe::delRecipe($_POST["delRecipeConfirm"]);
    header("Location: /app/tables/recipes/recipes.php");
}
$stream = file_get_contents("php://input");
// var_dump($_POST);
// var_dump($stream);
if($stream != null){
        //декодируем полученые данные
        if(isset($_SESSION["user"]["id"])){
            if(isset(json_decode($stream)->action)){
                $data = json_decode($stream)->data;
                $user_id = $_SESSION["user"]["id"];
                $action = json_decode($stream)->action;
                // var_dump($data);
                // var_dump($stream);
                $recipe = match($action){
                    // "addRecipe"=>Recipe::addRecipe($user_id, $data->price, $data->selfLifeDays, $data->discription, $data->data),
                    "addRecipeInBusket"=>Basket::addRecipe($data, $user_id),
                    "getAllUserRecipesByIngredient"=> Recipe::getAllUserRecipesByIngredient($data, $user_id),
                    "getAllIDiscriptionsInRecipes"=>RecipesDiscriptions::getAllDescriptionInRecipe($data),
                    "getAllIngredientsInRecipes"=>IngredientsInRecipes::getAllIngredientsInRecipe($data),
                    "getSerchRecipes"=>RecipesDiscriptions::serch($data,$user_id)
                };
                echo json_encode([
                    "productInBasket"=>$recipe,
                ], JSON_UNESCAPED_UNICODE);
            }

        }

}
