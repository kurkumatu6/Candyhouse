<?php
use app\models\Category;


session_start();
use app\models\Product;
use app\models\ProductInOrder;
use app\models\Image;
require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";


$stream = file_get_contents("php://input");
if($stream != null){
        //декодируем полученые данные

            $data = json_decode($stream)->data;
            // $user_id = $_SESSION["user"]["id"];
            $action = json_decode($stream)->action;
            // var_dump($data);
            // var_dump($stream);
            if($data == "all"){
                $recipe= Product::getAllProducts();
            }
            else{
                $recipe = match($action){
                    "productsOnCategory"=> Product::getProductsByCategory($data),
                    "getCountProduct"=>ProductInOrder::getCountProductInOrder($data),
                    "productsOnSerch"=> Product::serch($data),
                    "getCaqtegories" => Category::getAllCatehories(),
                    "delProduct"=>Product::delProduct($data),
                    "showDelSelectedProduct"=>Product::getProductsByIds($data),
                    "delSelectedProduct"=>Product::delMassProduct($data),
                    "getProductById"=>Product::getProductById($data),
                    "getImagesForProduct"=> Image::getAllImagesForProduct($data),
                };
            }

            echo json_encode([
                "productInBasket"=>$recipe,
            ], JSON_UNESCAPED_UNICODE);


}