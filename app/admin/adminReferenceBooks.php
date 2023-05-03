<?php

session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
use app\models\Category;
use app\models\IngredientsCategory;
use app\models\StatusOfClient;
use app\models\StatusOfOrder;
$title = "Админ справочники";
if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){

        $location = "referenc";
        $productsCategorys = Category::getAllCatehories();
        $ingredientsCategorys = IngredientsCategory::getAllIngrCategory();
        $clientsStatuses = StatusOfClient::getAllStatusesOfClient();
        $orderStatuses = StatusOfOrder::getAllStatuses();
    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminReferenceBooks.view.php";    
unset($_SESSION["error"]);
