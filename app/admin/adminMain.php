<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
use app\models\Order;
use app\models\StatusOfOrder;
$title = "Админ главная";
if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){

        $location = "main";
        $countOrdersByLastMounth = Order::getCountOrdersByLastMonth();
        $orders = Order::getAllOrdersLimit6();
        $ordersStatuses = StatusOfOrder::getAllStatuses();
        $arrDays= [];
        $ordersforDate = [];
        for ($i =0; $i<32;$i++){
            array_push( $arrDays , $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-$i,   date("Y"))));
        }
        $arrDays =array_reverse($arrDays);
        // var_dump($arrDays);
        foreach($arrDays as $date){
            if(Order::getCountOrdersFromDate($date)->count != 0){
                array_push($ordersforDate,[$date, Order::getCountOrdersFromDate($date)->count]);
            }
            
        }
        $json =json_encode($ordersforDate, JSON_UNESCAPED_UNICODE);
        // var_dump($ordersforDate);
    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminMain.view.php";    
unset($_SESSION["error"]);