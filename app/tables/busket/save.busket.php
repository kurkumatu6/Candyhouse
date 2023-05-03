<?php

session_start();
use App\models\Basket;

require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";

$stream = file_get_contents("php://input");
if($stream != null){
    //декодируем полученые данные
    // var_dump(json_decode($stream));
    $product_id = json_decode($stream)->data;
    $user_id = $_SESSION["user"]["id"];
    $action = json_decode($stream)->action;

    $productInBasket = match($action){
        "add"=>Basket::addProduct($product_id, $user_id),
        "del"=>Basket::deleteProduct($product_id, $user_id),
        "minus"=>Basket::minusProduct($product_id, $user_id),
        "addRecipe"=>Basket::addRecipe($product_id, $user_id),
        "delRecipe"=>Basket::deleteRecipe($product_id, $user_id),
        "minusRecipe"=>Basket::minusRecipe($product_id, $user_id),
        "clear"=>Basket::clear($user_id),
        "getMaxPerarationTime"=>Basket::getMaxPerarationTime($user_id),
    };
    echo json_encode([
        "productInBasket"=>$productInBasket,
        "allSum"=>Basket::allSum($user_id),
        "allCount"=>Basket::allCount($user_id)
    ], JSON_UNESCAPED_UNICODE);

}