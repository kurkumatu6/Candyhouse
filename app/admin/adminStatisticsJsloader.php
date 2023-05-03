<?php
use app\models\Client;
use app\models\Order;
use app\models\Product;
use app\models\ProductInOrder;

session_start();
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
                    "getCountProductsInOrdersByDates"=>ProductInOrder::getCountProductsInOrdersByDates($data->dateStart, $data->dateEnd),
                    "getDates"=>Client::getCountRegistrarionByTime($data->dateStart, $data->dateEnd),
                    "getAllProductsForSelector"=>Product::getAllProducts(),
                    "getProductPopularity"=>ProductInOrder::productPopulariti($data->dateStart, $data->dateEnd, $data->product_id),
                    "getMoneuByTime"=>Order::getMoneyByDates($data->dateStart, $data->dateEnd)
                };


            echo json_encode([
                "productInBasket"=>$recipe,
            ], JSON_UNESCAPED_UNICODE);


}