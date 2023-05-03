<?php

namespace app\models;

use App\base\PDOConnection;

class IngredientsInRecipes{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function add($ingredients, $recipe_id){
        $queryBase = "INSERT INTO `ingredients_in_recipes`(`ingredient_id`, `recipe_id`, `weight_G`) VALUES ";
        $queryParams = self::getParam($ingredients, "(?,?,?)");
        $values = [];
        foreach ($ingredients as $ingredient){
            array_push($values,$ingredient["ingredientId"]);
            array_push($values,$recipe_id);
            array_push($values,$ingredient["count"]);
        }
        $query = PDOConnection::make()->prepare($queryBase . $queryParams);
        $query->execute($values);
    }
    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }

    public static function getAllIngredientsInRecipe($recipe_id){
        $query = PDOConnection::make()->prepare("SELECT * FROM `ingredients_in_recipes` INNER JOIN ingredients ON ingredient_id = ingredients.id WHERE `recipe_id` = :recipe_id");
        $query->execute(["recipe_id"=>$recipe_id]);
        return $query->fetchAll();
    }
}