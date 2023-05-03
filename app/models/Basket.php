<?php

namespace app\models;

// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class Basket{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }
    public static function getAllProductInBucket($user_id){
        $query = PDOConnection::make()->prepare("SELECT baskets.*, products.name as product_name, products.price as price, (SELECT image FROM images WHERE images.product_id = products.id LIMIT 1) as image, baskets.count * products.price as price_position FROM baskets INNER JOIN products ON product_id = products.id WHERE user_id = :user_id");
        $query->execute(["user_id"=>$user_id]);

        return $query->fetchAll();
    }

    public static function getAllRecipesInBasket($user_id){
        $query = PDOConnection::make()->prepare("SELECT baskets.*, recipes.price as recipe_price, baskets.count * recipes.price as price_position, recipes.name as name FROM `baskets` INNER JOIN recipes ON baskets.recipe_id = recipes.id WHERE baskets.user_id = :user_id");
        $query->execute(["user_id"=>$user_id]);

        return $query->fetchAll();
    }

    public static function getUserBusket($user_id, $conn=null){
        $conn = $conn == null?PDOConnection::make():$conn;
        $query = $conn->prepare("SELECT baskets.*, products.price as price FROM baskets INNER JOIN products ON products.id= baskets.product_id  WHERE user_id = :user_id");
        $query->execute(["user_id"=>$user_id]);
        return $query->fetchAll();
    }
    public static function getUserBusketRecipe($user_id, $conn=null){
        $conn = $conn == null?PDOConnection::make():$conn;
        $query = $conn->prepare("SELECT baskets.*, recipes.price as price FROM baskets INNER JOIN recipes ON recipes.id= baskets.recipe_id  WHERE user_id = :user_id");
        $query->execute(["user_id"=>$user_id]);
        return $query->fetchAll();
    }
    public static function find($product_id, $user_id)
    {
        //найдем товар в корзине пользователя
        $query = PDOConnection::make()->prepare("SELECT baskets.*, products.name as product, products.price * baskets.count as position_price, products.price as product_price FROM `baskets` INNER JOIN products ON baskets.product_id = products.id WHERE baskets.product_id = :product_id AND baskets.user_id = :user_id;");
        $query->execute(["product_id" => $product_id, "user_id" => $user_id]);
        return $query->fetch();
    }

    public static function findRecipe($recipe_id, $user_id){
        $query = PDOConnection::make()->prepare("SELECT baskets.*, recipes.price as recipe_price, baskets.count * recipes.price as price_position FROM `baskets` INNER JOIN recipes ON baskets.recipe_id = recipes.id WHERE baskets.user_id = :user_id AND recipe_id = :recipe_id");
        $query->execute(["user_id"=>$user_id, "recipe_id"=>$recipe_id]);

        return $query->fetch();
    }

    public static function addProduct($product_id, $user_id){
        $prod = PDOConnection::make()->prepare("SELECT * FROM `baskets` WHERE product_id = :product_id AND user_id=:user_id");
        $prod->execute(["product_id"=>$product_id,"user_id"=>$user_id]);

        if($prod->fetch()){
            $query = PDOConnection::make()->prepare("UPDATE `baskets` SET `count`=`count`+1 WHERE product_id = :product_id AND user_id=:user_id");
            $query->execute(["product_id"=>$product_id,"user_id"=>$user_id]);
        }
        else{
            $query = PDOConnection::make()->prepare("INSERT INTO `baskets`(`id`, `user_id`, `product_id`, `count`) VALUES (NULL,:user_id,:product_id,1)");
            $query->execute(["product_id"=>$product_id,"user_id"=>$user_id]);
        }
        // $query = PDOConnection::make()->prepare("INSERT INTO `baskets`(`id`, `user_id`, `product_id`, `count`) VALUES (NULL,:user_id,:product_id,'1)");
        // $query->execute(["product_id"=>$product_id,"user_id"=>$user_id]);
        return self::find($product_id,$user_id);
    }
    public static function addRecipe($recipe_id, $user_id){
        $prod = PDOConnection::make()->prepare("SELECT * FROM `baskets` WHERE recipe_id = :recipe_id AND user_id=:user_id");
        $prod->execute(["recipe_id"=>$recipe_id,"user_id"=>$user_id]);
        // var_dump($prod);
        if($prod->fetch()){
            $query = PDOConnection::make()->prepare("UPDATE `baskets` SET `count`=`count`+1 WHERE recipe_id = :recipe_id AND user_id=:user_id");
            $query->execute(["recipe_id"=>$recipe_id,"user_id"=>$user_id]);
        }
        else{
            $query = PDOConnection::make()->prepare("INSERT INTO `baskets`(`id`, `user_id`, `recipe_id`, `count`) VALUES (NULL,:user_id,:recipe_id,1)");
            $query->execute(["recipe_id"=>$recipe_id,"user_id"=>$user_id]);
        }
        // $query = PDOConnection::make()->prepare("INSERT INTO `baskets`(`id`, `user_id`, `product_id`, `count`) VALUES (NULL,:user_id,:product_id,'1)");
        // $query->execute(["product_id"=>$product_id,"user_id"=>$user_id]);
        return self::findRecipe($recipe_id,$user_id);
    }
    public static function minusRecipe($recipe_id, $user_id){
        $query = PDOConnection::make()->prepare("UPDATE `baskets` SET `count`=`count`-1 WHERE recipe_id = :recipe_id AND user_id=:user_id");
        $query->execute(["recipe_id"=>$recipe_id,"user_id"=>$user_id]);
        $prod =self::findRecipe($recipe_id,$user_id);
        // var_dump($prod->count);
        if($prod->count == 0){
            $query = PDOConnection::make()->prepare("DELETE FROM `baskets` WHERE product_id = :product_id AND user_id=:user_id");
            $query->execute(["product_id"=>$recipe_id,"user_id"=>$user_id]);
            return "delete";
        }
        else{
            return $prod;
        }
 
    }
    public static function minusProduct($product_id, $user_id){
        $query = PDOConnection::make()->prepare("UPDATE `baskets` SET `count`=`count`-1 WHERE product_id = :product_id AND user_id=:user_id");
        $query->execute(["product_id"=>$product_id,"user_id"=>$user_id]);
        $prod =self::find($product_id,$user_id);
        // var_dump($prod->count);
        if($prod->count == 0){
            $query = PDOConnection::make()->prepare("DELETE FROM `baskets` WHERE product_id = :product_id AND user_id=:user_id");
            $query->execute(["product_id"=>$product_id,"user_id"=>$user_id]);
            return "delete";
        }
        else{
            return $prod;
        }
 
    }
    public static function deleteProduct($product_id, $user_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `baskets` WHERE product_id = :product_id AND user_id=:user_id");
        $query->execute(["product_id"=>$product_id,"user_id"=>$user_id]);
        return "delete";
    }
    public static function deleteRecipe($recipe_id, $user_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `baskets` WHERE recipe_id = :recipe_id AND user_id=:user_id");
        $query->execute(["recipe_id"=>$recipe_id,"user_id"=>$user_id]);
        return "delete";
    }
    public static function clear($user_id, $conn = null){
        $conn = $conn??PDOConnection::make();
        $query = $conn->prepare("DELETE FROM `baskets` WHERE user_id = :user_id");
        $query->execute(["user_id"=>$user_id]);
    }
    public static function allSum($user_id)
    {
        $query = PDOConnection::make()->prepare("SELECT SUM(products.price * baskets.count) as sum FROM baskets INNER JOIN products ON product_id = products.id WHERE user_id = :user_id ");

        $query->execute([
            "user_id" => $user_id,
        ]);
        $query2 = PDOConnection::make()->prepare("SELECT SUM(recipes.price * baskets.count) FROM `baskets` INNER JOIN recipes ON recipes.id = baskets.recipe_id WHERE baskets.user_id = :user_id");

        $query2->execute([
            "user_id" => $user_id,
        ]);

        return $query->fetch(\PDO::FETCH_COLUMN) + $query2->fetch(\PDO::FETCH_COLUMN);
    }
    
    //количество товаров корзины пользователя
    public static function allCount($user_id)
    {
        $query = PDOConnection::make()->prepare("SELECT SUM(baskets.count) as count FROM baskets WHERE user_id = :user_id");

        $query->execute([
            "user_id" => $user_id,
        ]);

        return $query->fetch(\PDO::FETCH_COLUMN);
    }

    public static function getMaxPerarationTime($user_id){
        $query = PDOConnection::make()->prepare("SELECT products.preparation_time as days, products.name FROM `baskets` INNER JOIN products on products.id = baskets.product_id WHERE user_id = :user_id AND products.preparation_time = (SELECT MAX(preparation_time) FROM products WHERE products.id IN (SELECT product_id FROM baskets WHERE user_id = :user_id));");
        $query->execute(["user_id"=>$user_id]);
        $maxPir = $query->fetch();
        if($maxPir == null){
            return ["days"=>2];
        }
        else{
            return $maxPir;
        }
    }
}