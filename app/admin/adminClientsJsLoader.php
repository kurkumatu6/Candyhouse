<?php
use app\models\Client;
use app\models\StatusOfClient;



session_start();


require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";
use app\models\Order;
$stream = file_get_contents("php://input");
if($stream != null){
        //декодируем полученые данные

            $data = json_decode($stream)->data;
            // $user_id = $_SESSION["user"]["id"];
            $action = json_decode($stream)->action;
            // var_dump($data);
            // var_dump($stream);
                $recipe = match($action){
                   "getAllOrdersByClient"=>Order::getAllOrdersByUser($data),
                   "getStatusNameById"=>StatusOfClient::getStatusById($data),
                   "setClientStatus"=>Client::setClientStatusById($data->clientId,$data->status_id),
                };

            echo json_encode([
                "productInBasket"=>$recipe,
            ], JSON_UNESCAPED_UNICODE);


}