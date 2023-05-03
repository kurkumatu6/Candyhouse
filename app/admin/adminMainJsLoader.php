<?php


session_start();
use app\models\Order;
require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";

$stream = file_get_contents("php://input");
if($stream != null){
        //декодируем полученые данные

            $data = json_decode($stream)->data;
            // $user_id = $_SESSION["user"]["id"];
            $action = json_decode($stream)->action;
            // var_dump($data);
            // var_dump($stream);
                $recipe = match($action){
                    "getCountOfOrdersOnDate"=>Order::getCountOrdersFromDate($data),
                };

            echo json_encode([
                "productInBasket"=>$recipe,
            ], JSON_UNESCAPED_UNICODE);
}