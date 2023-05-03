<?php

use app\models\Image;
use app\models\Product;
use app\models\Review;

require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
// var_dump($_GET);
$product = Product::getProductById($_GET["id"]);
$images = Image::getAllImagesForProduct($_GET["id"]);
$countImages = count($images);
// var_dump($images);
$title = $product->name;
$ingredients = mb_split(" ", $product->ingredient_list);
$reviwes = Review::getAllReviewsForProduct($_GET["id"]);
require_once $_SERVER["DOCUMENT_ROOT"]. "/views/tables/product/product.view.php";
