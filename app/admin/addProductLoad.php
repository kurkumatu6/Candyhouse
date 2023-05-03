<?php
session_start();
use app\models\Product;

require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

if( $_POST["productName"] !="" && $_POST["preparation_time"] !="" && $_POST["ingredient_list"] !="" && $_POST["category"] !="" && $_POST["calories"] !="" && $_POST["price"] !="" && $_POST["weight_g"] !="" && $_POST["self_life_days"] !="" ){
    Product::addProduct($_POST["productName"], $_POST["preparation_time"],$_POST["ingredient_list"],$_POST["category"],$_POST["calories"],$_POST["price"],$_POST["weight_g"],$_POST["self_life_days"],$_FILES);
}
else{
$_SESSION["error"]["prodAdd"] = "Продукт не добавлен поля обязательные к заполнению не были заполнены";
}

header("Location: /app/admin/adminProduct.php");

