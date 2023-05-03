<?php

namespace app\models;
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class RecipesInOrder{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function addRecipes($busket, $order_id, $conn){
        $conn = $conn??PDOConnection::make();
        $queryBase = "INSERT INTO `recipes_in_orders`(`recipe_id`, `order_id`, `count`) VALUES  ";
        $queryParams = self::getParam($busket, "(?,?,?)");
        $values = [];
        foreach ($busket as $recipe){
            array_push($values,$recipe->recipe_id);
            array_push($values,$order_id);
            array_push($values,$recipe->count);
        }
        // var_dump($values);
        if(count($values) >0){
            // var_dump($queryBase . $queryParams);
            $query = $conn->prepare($queryBase . $queryParams);
            $query->execute($values);
        }

    }
    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }

    public static function getAllRecipesInOrder($order_id){
        $query = PDOConnection::make()->prepare("SELECT recipes_in_orders.*, recipes.price, recipes.name as name, recipes.id as number FROM `recipes_in_orders` INNER JOIN recipes ON recipes.id = recipes_in_orders.recipe_id WHERE recipes_in_orders.order_id = :order_id");
        $query->execute(['order_id'=>$order_id]);
        return $query->fetchAll();

    }

    public static function setDateOfManufacture($ricDates){
        $query = PDOConnection::make()->prepare("UPDATE `recipes_in_orders` SET `date_of_manufacture` = :date_of_manufacture WHERE recipes_in_orders.recipe_id = :product_id AND recipes_in_orders.order_id = :order_id");
        foreach($ricDates as $ric){
            $query->execute(["date_of_manufacture"=>$ric->date,"product_id"=>$ric->idRic,"order_id"=>$ric->orderId]);
        }
    }


}