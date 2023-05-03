<?php
ini_set('display_errors', true);
use app\models\Category;

use App\base\PDOConnection;
use app\models\Image;
use app\models\Product;
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
$title = "Каталог";

$products = [];
// var_dump($products);
// var_dump($products);
// $images = [];
// foreach($products as $product){
//    array_push($images, Image::getAllImagesForProduct($product->id));
// }
$categories = Category::getAllCatehories();
// var_dump($categories);

require_once $_SERVER["DOCUMENT_ROOT"]. "/views/index.view.php";

