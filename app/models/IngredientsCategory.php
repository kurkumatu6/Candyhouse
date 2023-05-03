<?php

namespace app\models;
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class IngredientsCategory{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllIngrCategory(){
        $query = PDOConnection::make()->query("SELECT * FROM `ingredients_categorys`");
        return $query->fetchAll();
    }
    public static function addCategory($name){
        $queryTry = PDOConnection::make()->prepare("SELECT * FROM ingredients_categorys WHERE name = :name");
        $queryTry->execute(["name"=>$name]);
        $category= $queryTry->fetch();
        if($category == null){
            $query= PDOConnection::make()->prepare("INSERT INTO `ingredients_categorys`(`id`, `name`) VALUES (NULL, :name)");
            $query->execute(["name"=>$name]);
            return true;
        }
        else{
            return false;
        }
    }

    public static function delIngrcategory($category_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `ingredients_categorys` WHERE id = :category_id ");
        $query->execute(["category_id"=>$category_id]);
    }
}