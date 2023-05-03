<?php

use app\models\Ingredient;
use app\models\IngredientsCategory;

session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
$title = "Админ ингредиенты";

if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){

        $location = "ingredients";
        $ingredients = Ingredient::getAllIngredients();
        $categorys = IngredientsCategory::getAllIngrCategory();

    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminIngredients.view.php";    
