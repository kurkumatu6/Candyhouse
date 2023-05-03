<?php

namespace app\models;

// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class Ingredient{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllIngredients(){
        $query = PDOConnection::make()->query("SELECT ingredients.*, ingredients_categorys.name as category FROM `ingredients` INNER JOIN ingredients_categorys ON ingredients.ingredient_category_id = ingredients_categorys.id");
        return $query->fetchAll();
    }

    public static function getIngredientInUserRecipes($user_id, $ingredient_id){
        $query = PDOConnection::make()->prepare("SELECT DISTINCT ingredients_in_recipes.ingredient_id, (SELECT COUNT(recipes.id) FROM `recipes` INNER JOIN ingredients_in_recipes ON ingredients_in_recipes.recipe_id = recipes.id WHERE ingredients_in_recipes.ingredient_id = :ingredient_id AND recipes.client_id = :client_id) as count, ingredients.ingredient as name FROM `recipes` INNER JOIN ingredients_in_recipes ON ingredients_in_recipes.recipe_id = recipes.id INNER JOIN ingredients ON ingredients.id = ingredients_in_recipes.ingredient_id WHERE ingredients_in_recipes.ingredient_id = :ingredient_id  AND recipes.client_id = :client_id");
        $query->execute(["client_id"=>$user_id, "ingredient_id"=>$ingredient_id]);
        return $query->fetch();
    }

    public static function getIngredientsByCategory($ingredientCategoryId){
        $query = PDOConnection::make()->prepare("SELECT ingredients.*, ingredients_categorys.name as category FROM `ingredients` INNER JOIN ingredients_categorys ON ingredients.ingredient_category_id = ingredients_categorys.id WHERE ingredients.ingredient_category_id = :ingredient_category_id");
        $query->execute(["ingredient_category_id" => $ingredientCategoryId]);
        return $query->fetchAll();
    }

    public static function serch($serchText ){
        $query = PDOConnection::make()->prepare("SELECT ingredients.*, ingredients_categorys.name as category FROM `ingredients` INNER JOIN ingredients_categorys ON ingredients.ingredient_category_id = ingredients_categorys.id WHERE ingredients.ingredient LIKE (:serchText)");
        $query->execute(["serchText"=> "%".$serchText."%"]);
        return $query->fetchAll();
    }

    public static function delIngredient($ingredient_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `ingredients` WHERE id = :ingredient_id");
        $query->execute(["ingredient_id"=> $ingredient_id]);
    }

    public static function addIngredient($ingredient,$price_100g ,$calories_100g,$self_life_days,$ingredient_category_id){
        $query = PDOConnection::make()->prepare("INSERT INTO `ingredients`(`id`, `ingredient`, `price_100g`, `calories_100g`, `self_life_days`, `ingredient_category_id`) VALUES (NULL, :ingredient , :price_100g , :calories_100g , :self_life_days , :ingredient_category_id)");
        return $query->execute(["ingredient"=>$ingredient,"price_100g"=>$price_100g,"calories_100g"=>$calories_100g,"self_life_days"=>$self_life_days,"ingredient_category_id"=>$ingredient_category_id]);
         
    }

    public static function getIngerdientsByIds($ingredientIds){
        if(count( $ingredientIds) != 0){
            $queryTextBase = "SELECT * FROM `ingredients` WHERE id IN ( ";
            $queryTextParam = self::getParam($ingredientIds, "?");
            $queryTextEnd = " );";
            // var_dump($queryTextBase.$queryTextParam.$queryTextEnd);
            $query = PDOConnection::make()->prepare($queryTextBase.$queryTextParam.$queryTextEnd);
            $query->execute($ingredientIds);
            return $query->fetchAll();
        }
        // var_dump($ingredientIds);

    }

    public static function delMassIngredients($ingredientIds){
        $queryTextBase = "DELETE FROM `ingredients` WHERE id IN ( ";
        $queryTextParam = self::getParam($ingredientIds, "?");
        $queryTextEnd = " );";
        $query = PDOConnection::make()->prepare($queryTextBase.$queryTextParam.$queryTextEnd);
        $query->execute($ingredientIds);
    }

    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }

    public static function getIngredientById($ingredient_id){
        $query = PDOConnection::make()->prepare("SELECT ingredients.*, ingredients_categorys.name as category FROM `ingredients` INNER JOIN ingredients_categorys ON ingredients.ingredient_category_id = ingredients_categorys.id WHERE ingredients.id = :ingredient_id");
        $query->execute(["ingredient_id"=>$ingredient_id]);
        return $query->fetch();

    }
    public static function changeIngredientValue($ingredient_id, $ingredient, $price_100g, $calories_100g, $self_life_days, $ingredient_category_id){
        $query = PDOConnection::make()->prepare("UPDATE `ingredients` SET `ingredient`=:ingredient,`price_100g`=:price_100g,`calories_100g`=:calories_100g,`self_life_days`=:self_life_days,`ingredient_category_id`=:ingredient_category_id WHERE id = :ingredient_id");
        $query->execute(["ingredient_id"=>$ingredient_id,"ingredient"=>$ingredient,"price_100g"=>$price_100g,"calories_100g"=>$calories_100g,"self_life_days"=>$self_life_days,"ingredient_category_id"=>$ingredient_category_id]);
    }
    
}