<?php
use app\models\Product;
use app\models\Review;
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

$title = "Админ отзывы";
if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){

        $location = "reviews";
        $reviews = Review::getAllReviews();
        $products = Product::getAllProducts();
    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminReview.view.php";    