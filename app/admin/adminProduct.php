<?php

use app\models\Category;
use app\models\Product;
use app\models\ProductInOrder;

session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

$title = "Админ товары";
if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){

        $location = "products";

        $categories = Category::getAllCatehories();
        $products = Product::getAllProducts();
        $productsCount = [];
        foreach($products as $product){
            $productsCount[$product->id]= ProductInOrder::getCountProductInOrder($product->id);
        }
    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminProducts.view.php";    
unset($_SESSION["error"]);
