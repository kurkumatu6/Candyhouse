<?php
namespace app\models;
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
include_once $_SERVER["DOCUMENT_ROOT"]. "/app/helpers/ImageControls.php";

use App\base\PDOConnection;
use app\models\ImageControls;

class RecipesDiscriptions{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function add($discript, $recipe_id){
        $queryBaseAddDisc = "INSERT INTO `recipes_discriptions`( `recipe_id`, `step_number`, `discription`, `image`) VALUES  ";
        $queryParamsAddDisc = self::getParam($discript, "(?,?,?,?)");
        $valuesAddDisc = [];
        $errorImageLoader = [];
        foreach ($discript as $discript){
            $image = ImageControls::addImage($discript["img"]);
            array_push($valuesAddDisc,$recipe_id);
            array_push($valuesAddDisc,$discript["stepId"]);
            array_push($valuesAddDisc,$discript["discript"]);
            if(!$image["error"]){
                array_push($valuesAddDisc, $image["message"]);
            }
            else{
                array_push($errorImageLoader, $image["message"]);
                array_push($valuesAddDisc, "");
            }
        }
        $query = PDOConnection::make()->prepare($queryBaseAddDisc . $queryParamsAddDisc);
        $query->execute($valuesAddDisc);
        if(!empty($errorImageLoader)){
            return $errorImageLoader;
        }
    }
    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }

    public static function getAllDescriptionInRecipe($recipe_id){
        $query = PDOConnection::make()->prepare("SELECT * FROM `recipes_discriptions` WHERE `recipe_id` = :recipe_id");
        $query->execute(["recipe_id"=>$recipe_id]);
        return $query->fetchAll();
    }

    public static function serch($serch,$user_id){
        $query = PDOConnection::make()->prepare("SELECT DISTINCT recipes_discriptions.recipe_id, recipes.name as name  FROM `recipes_discriptions` INNER JOIN recipes ON recipes.id = recipes_discriptions.recipe_id WHERE (recipes_discriptions.discription LIKE(:serch) OR recipes.name LIKE(:serchName)) AND recipes.client_id = :user_id");
        $query->execute(['serch'=>"%".$serch."%",'serchName'=>"%".$serch."%","user_id"=>$user_id]);
        return $query->fetchAll();
    }
}