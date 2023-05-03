<?php
use app\models\RecipesInOrder;


session_start();

use app\models\Order;
use app\models\StatusOfOrder;
require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";


$stream = file_get_contents("php://input");
if($stream != null){
        //декодируем полученые данные

        // var_dump($stream);

            $data = json_decode($stream)->data;
            // $user_id = $_SESSION["user"]["id"];
            $action = json_decode($stream)->action;
            // var_dump($data);
            if($data == "all"){
                $recipe= Order::getAllOrders();
            }
            else{
                $recipe = match($action){
                    "getOrdersByStatus" =>  Order::getOrdersByStatus($data ),
                    "getAllStatusesOfOrder"=> StatusOfOrder::getAllStatuses(),
                    "changeStatusOforder"=> Order::changeOrderStatus($data->orderId, $data->statusId),
                    "getOrderById"=> Order::getOrderInfoById($data),
                    "getAllProductInOrder"=>Order::getAllProductsInOrder($data) ,
                    "getAllRecipesInOrder"=>RecipesInOrder::getAllRecipesInOrder($data),
                    "getUserWarning"=>Order::getUserWarning($data),
                    "censelOrderConfirm"=>Order::changeStatusToCensel($data->orderId,$data->statusId,$data->user_id,$data->warning,$data->reason_warning,$data->recipesIds,$data->reason_cancellation),
                    "setDateOfManufacture"=>Order::setAllDateOfmanufactures($data->prodDates, $data->recipeDates, $data->orderId)
                };
            }
            // {"orderId":e.target.dataset.orderId, "statusId": 2, "user_id":document.querySelector("#block_user").dataset.userId, "warning":document.querySelector("#reason_warning").value,"reason_warning":reasonWarning, "recipesIds":delRecipesIds, "reason_cancellation": reasonCancellation}
            echo json_encode([
                "productInBasket"=>$recipe,
            ], JSON_UNESCAPED_UNICODE);

}