<?php
session_start();
// var_dump($_POST);

use app\models\Recipe;
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

$ingredients = [];
$selfLifeDays= 100000000000000000000;
$discriptions = [];
$price = 0;
// var_dump($_FILES);

if(isset($_POST["ingredient-id"])){
    foreach($_POST["ingredient-id"] as $id){
        array_push($ingredients, ["ingredientId"=>$id, "count"=>$_POST["ingr".$id]]);
        if($_POST["self-life-days".$id]< (int)$selfLifeDays){
            $selfLifeDays = $_POST["self-life-days".$id];
        }
        $price += (int)$_POST["ingr".$id] * (float) $_POST["price".$id]/100;
    }
    
    foreach($_POST["steps-id"] as $stepsId){
        $tempArray = ["stepId"=>$stepsId,"discript"=>$_POST["step".$stepsId], "img"=> $_FILES["img".$stepsId]];
        array_push($discriptions,$tempArray);
    }
    

    // var_dump($ingredients);
    // var_dump($price);
    // var_dump($selfLifeDays);
    Recipe::addRecipe($_SESSION["user"]["id"], $price, $selfLifeDays, $discriptions, $ingredients, $_POST["recipe_name"]);
    
header("Location: /app/tables/recipes/recipes.php");
}
else{
    $_SESSION["error"]["ingredient_ilst"]= "Список ингредиентов не может быть пустым";
    header("Location: /app/tables/recipes/construct.php");
}
