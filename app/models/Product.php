<?php

namespace app\models;
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/Image.php";
use App\base\PDOConnection;
use app\models\Image;


class Product{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllProducts(){
        $query = PDOConnection::make()->query("SELECT products.*, categories.category as category, (SELECT image FROM images WHERE images.product_id = products.id LIMIT 1) as image FROM `products` INNER JOIN categories ON categories.id = products.category_id");
        return $query->fetchAll();
    }
    public static function getAllProductsLimit($limit){
        $query = PDOConnection::make()->query("SELECT products.*, categories.category as category, (SELECT image FROM images WHERE images.product_id = products.id LIMIT 1) as image FROM `products` INNER JOIN categories ON categories.id = products.category_id LIMIT ".intval($limit));
        $query->execute();
        return $query->fetchAll();
    }

    public static function getProductsByCategoryLimit($category_id, $limit){
        $query = PDOConnection::make()->prepare("SELECT products.*, categories.category as category, (SELECT image FROM images WHERE images.product_id = products.id LIMIT 1) as image FROM `products`INNER JOIN categories ON categories.id = products.category_id WHERE category_id = :category_id LIMIT ".intval($limit));
        $query->execute(["category_id"=>$category_id]);
        return $query->fetchAll();
    }
    public static function getProductById($id){
        $query = PDOConnection::make()->prepare("SELECT products.*, categories.category as category FROM `products` INNER JOIN categories ON categories.id = products.category_id WHERE products.id = :id");
        $query->execute(["id"=> $id]);
        return $query->fetch();
    }

    public static function getProductsByCategory($category_id){
        $query = PDOConnection::make()->prepare("SELECT products.*, categories.category as category, (SELECT image FROM images WHERE images.product_id = products.id LIMIT 1) as image FROM `products`INNER JOIN categories ON categories.id = products.category_id WHERE category_id = :category_id");
        $query->execute(["category_id"=>$category_id]);
        return $query->fetchAll();
    }
    
    public static function serch($serchText){
        $query = PDOConnection::make()->prepare("SELECT products.*, categories.category as category FROM products INNER JOIN categories ON categories.id = products.category_id WHERE name LIKE :serchText");
        $query->execute(["serchText" => "%".$serchText."%"]);
        return $query->fetchAll();
    }

    public static function delProduct($productId){
        Image::delAllImagesForProduct($productId);
        $query = PDOConnection::make()->prepare("DELETE FROM `products` WHERE id = :id");
        $query->execute(["id"=>$productId]);

    }

    public static function addProduct($name, $preparation_time, $ingredient_list, $category_id, $calories, $price, $weight_g, $self_life_days, $images){
        $conn = PDOConnection::make();
        // var_dump(["name"=>$name,"preparation_time"=>$preparation_time,"ingredient_list"=>$ingredient_list,"category_id"=>$category_id,"calories"=>$calories,"price"=>$price,"weight_g"=>$weight_g,"self_life_days"=>$self_life_days]);
       $query = $conn->prepare("INSERT INTO `products`(`id`, `name`, `preparation_time`, `ingredient_list`, `category_id`, `calories`, `price`, `weight_g`, `self_life_days`) VALUES (NULL,:name,:preparation_time,:ingredient_list,:category_id,:calories,:price,:weight_g,:self_life_days)");
       $query->execute(["name"=>$name,"preparation_time"=>$preparation_time,"ingredient_list"=>$ingredient_list,"category_id"=>$category_id,"calories"=>$calories,"price"=>$price,"weight_g"=>$weight_g,"self_life_days"=>$self_life_days]);
        $productId = $conn->lastInsertId();
        Image::addImagesForProduct($productId, $images);
    }

    public static function changeProductValues($productId, $name, $preparation_time, $ingredient_list, $category_id, $calories, $price, $weight_g, $self_life_days, $images, $delImagesIds= false){
        $conn = PDOConnection::make();
        $query = $conn->prepare("UPDATE `products` SET `name`=:name,`preparation_time`=:preparation_time,`ingredient_list`=:ingredient_list,`category_id`=:category_id,`calories`=:calories,`price`=:price,`weight_g`=:weight_g,`self_life_days`=:self_life_days WHERE id = :id");
        $query->execute(["name"=>$name,"preparation_time"=>$preparation_time,"ingredient_list"=>$ingredient_list,"category_id"=>$category_id,"calories"=>$calories,"price"=>$price,"weight_g"=>$weight_g,"self_life_days"=>$self_life_days,"id"=>$productId,]);
        foreach ($images["change"] as $image){
            Image::changeImage($productId, $image["id"], $image["image"]);
        }
            Image::addImagesForProduct($productId,$images["add"]);
            if($delImagesIds){
                Image::delMassImages($delImagesIds);
            }

    }

    public static function delMassProduct($productsIdArray){
        foreach( $productsIdArray as  $productId){
            Image::delAllImagesForProduct($productId);
        }
        $queryTextBase = "DELETE FROM `products` WHERE id IN ( ";
        $queryTextParam = self::getParam($productsIdArray, "?");
        $queryTextEnd = " );";
        $query = PDOConnection::make()->prepare($queryTextBase.$queryTextParam.$queryTextEnd);
        $query->execute($productsIdArray);
    }

    public static function getProductsByIds($productsIdArray){
        if(count($productsIdArray) >0){
            $queryTextBase = "SELECT * FROM `products` WHERE id IN ( ";
            $queryTextParam = self::getParam($productsIdArray, "?");
            $queryTextEnd = " );";
            // var_dump($queryTextBase.$queryTextParam.$queryTextEnd);
            $query = PDOConnection::make()->prepare($queryTextBase.$queryTextParam.$queryTextEnd);
            $query->execute($productsIdArray);
            return $query->fetchAll();
        }

    }
    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }

}
// , (SELECT * FROM images WHERE images.product_id = products.id) as images 