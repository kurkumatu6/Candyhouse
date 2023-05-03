<?php 

namespace app\models;

// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class Category{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllCatehories(){
        $query = PDOConnection::make()->query("SELECT * FROM `categories`");
        return $query->fetchAll();
    }

    public static function addCategory($name){
        $queryTry = PDOConnection::make()->prepare("SELECT * FROM categories WHERE category = :category");
        $queryTry->execute(["category"=>$name]);
        $category= $queryTry->fetch();
        if($category == null){
            $query= PDOConnection::make()->prepare("INSERT INTO `categories`(`id`, `category`) VALUES (NULL,:name)");
            $query->execute(["name"=>$name]);
            return true;
        }
        else{
            return false;
        }
    }

    public static function delProdCategory($category_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `categories` WHERE id = :category_id");
        $query->execute(["category_id"=>$category_id]);

    }
}