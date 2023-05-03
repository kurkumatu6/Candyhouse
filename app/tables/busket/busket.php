<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/bootstrap.php';
use App\models\Basket;

require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";
$title = "Корзина";
$user_id = $_SESSION["user"]["id"];
$baskets = Basket::getAllProductInBucket($user_id);
$recipes = Basket::getAllRecipesInBasket($user_id);
// var_dump($recipes);
$summer = Basket::allSum($user_id);
$count = Basket::allCount($user_id);
 require_once $_SERVER["DOCUMENT_ROOT"]. "/views/tables/busket/busket.view.php";
