<?php
use app\models\Product;
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

$categories = json_decode($_GET['categories']);
$limit = json_decode($_GET['limit']);
// var_dump($limit);
if($categories == "0")
{
    $res = Product::getAllProductsLimit($limit);
}
else
{
    $res = Product::getProductsByCategoryLimit($categories, $limit);
}
echo json_encode($res, JSON_UNESCAPED_UNICODE);
