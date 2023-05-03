<?php
use app\models\Client;
use app\models\Order;
use app\models\RecipesInOrder;
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

$orders = Order::getAllOrdersByUser($_SESSION['user']["id"]);
$title = "Профиль";
$ordersProducts = [];
$ordersRecipes = [];
foreach($orders as $order){
    $ordersProducts[$order->id] = Order::getAllProductsInOrder($order->id);
    $ordersRecipes[$order->id] = RecipesInOrder::getAllRecipesInOrder($order->id);
}
$client = Client::getClientForId($_SESSION['user']["id"]);
// var_dump($ordersProducts);
// var_dump($ordersRecipes);
// var_dump($ordersProducts);
// var_dump($client);

require_once $_SERVER["DOCUMENT_ROOT"]. "/views/tables/user/profile.view.php";