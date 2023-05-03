<?php

use app\models\Product;

require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";


$images = ["change"=>[], "add"=>[], "del"=>[]];
// var_dump($_POST);
// var_dump($_FILES);
// foreach $_FILES
if(isset($_POST["imagesChangeIds"])){
    foreach($_POST["imagesChangeIds"] as $imageId){
        if($_FILES["imagesChange".$imageId]["tmp_name"]!=""){
            array_push($images["change"], ["id"=>$imageId,"image"=>$_FILES["imagesChange".$imageId]]);
        }
    
    }
}

foreach($_FILES as $key=> $image){
    if(str_contains($key, "imagesAdd")){
        $images["add"][$key] = $image;
    }
}
if(isset($_POST["imagesDelIds"])){
    Product::changeProductValues($_POST["product_id"],$_POST["productName"],$_POST["preparation_time"],$_POST["ingredient_list"], $_POST["category"],$_POST["calories"], $_POST["price"], $_POST["weight_g"], $_POST["self_life_days"], $images,$_POST["imagesDelIds"]);
}
else{
    Product::changeProductValues($_POST["product_id"],$_POST["productName"],$_POST["preparation_time"],$_POST["ingredient_list"], $_POST["category"],$_POST["calories"], $_POST["price"], $_POST["weight_g"], $_POST["self_life_days"], $images);
}
header("Location: /app/admin/adminProduct.php");
// var_dump($images);