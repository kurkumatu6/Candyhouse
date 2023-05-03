<?php


session_start();

use app\models\Category;
use app\models\IngredientsCategory;
use app\models\StatusOfClient;
use app\models\StatusOfOrder;
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
                    "delProductCategory" => Category::delProdCategory($data)  ,
                    "delIngredientCategory"=> IngredientsCategory::delIngrcategory($data),
                    "delClientsSatus"=> StatusOfClient::delClientStatus($data),
                    "delOrderStatus"=> StatusOfOrder::delOrderStatus($data),
                    "getAllProductCategory"=> Category::getAllCatehories(),
                    "getAllIngredientCategory"=> IngredientsCategory::getAllIngrCategory(),
                    "getAllClientsSatus"=> StatusOfClient::getAllStatusesOfClient() ,
                    "getAllOrderStatus"=> StatusOfOrder::getAllStatuses(),
                };

            echo json_encode([
                "productInBasket"=>$recipe,
            ], JSON_UNESCAPED_UNICODE);
}