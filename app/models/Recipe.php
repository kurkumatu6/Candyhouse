<?php

namespace app\models;

// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/Basket.php";
require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/IngredientsInRecipes.php";
require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/RecipesDiscriptions.php";
use App\base\PDOConnection;
use app\models\IngredientsInRecipes;
use app\models\RecipesDiscriptions;
use app\models\Basket;
class Recipe{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function addRecipe($user_id, $price, $days, $discript, $ingredients, $name){
        $conn = PDOConnection::make();
        $query = $conn->prepare("INSERT INTO `recipes`(`id`, `client_id`, `price`, `self_live_days`,  `name`) VALUES (NULL,:client_id,:price,:self_live_days, :name)");
        $query->execute(["client_id"=>$user_id,"price"=>$price,"self_live_days"=>$days, "name"=>$name]);
        $recipe_id =$conn->lastInsertId();

        IngredientsInRecipes::add($ingredients, $recipe_id);
        RecipesDiscriptions::add($discript, $recipe_id);
        // Basket::addRecipe($recipe_id, $user_id);
    }
    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }

    public static function getAllUserRecipes($user_id){
        $query = PDOConnection::make()->prepare("SELECT recipes.*, (SELECT COUNT(recipe_id) FROM recipes_in_orders INNER JOIN orders ON orders.id = recipes_in_orders.order_id WHERE recipes_in_orders.recipe_id = recipes.id AND orders.status_of_order_id = 1) as countInOrders FROM `recipes` WHERE client_id = :client_id");
        $query->execute(['client_id'=>$user_id]);
        return $query->fetchAll();
    }

    public static function getAllUserRecipesByIngredient($ingredientID, $user_id){
        $query = PDOConnection::make()->prepare("SELECT * FROM `recipes` INNER JOIN ingredients_in_recipes ON ingredients_in_recipes.recipe_id = recipes.id WHERE ingredients_in_recipes.ingredient_id = :ingredient_id AND recipes.client_id = :client_id;");
        $query->execute(["ingredient_id"=>$ingredientID, "client_id"=>$user_id]);
        return $query->fetchAll();
    }

    public static function getRecipeById($recipe_id){
        $query = PDOConnection::make()->prepare("SELECT recipes.*, (SELECT COUNT(recipe_id) FROM recipes_in_orders INNER JOIN orders ON orders.id = recipes_in_orders.order_id WHERE recipes_in_orders.recipe_id = recipes.id AND orders.status_of_order_id = 1) as countInOrders FROM `recipes` WHERE id = :id");
        $query->execute(["id"=>$recipe_id]);
        return $query->fetch();
    }

    public static function delRecipe($recipe_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `recipes` WHERE id= :recipe_id");
        $query->execute(['recipe_id'=>$recipe_id]);

    }

    public static function delMassRecipe($recipesIds){
        $queryBase = "DELETE FROM `recipes` WHERE id IN (";
        $queryParam = self::getParam($recipesIds,"?");
        $query = PDOConnection::make()->prepare($queryBase.$queryParam.");");
        $query->execute($recipesIds);

    }
}
// "SELECT (
//     IFNULL((SELECT SUM(products_in_orders.count * 
//                 (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
//      FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
    
//     +
//     IFNULL((SELECT SUM(recipes_in_orders.count * 
//                     (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
//         FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  ) as sum 
// FROM orders WHERE orders.id = :order_id"