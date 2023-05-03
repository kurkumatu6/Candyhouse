<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
use app\models\Order;
use app\models\StatusOfOrder;
$title = "Админ заказы";
if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){

        $location = "orders";
        $orders = Order::getAllOrders();
        $ordersStatuses = StatusOfOrder::getAllStatuses();
    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminOrders.view.php";    
