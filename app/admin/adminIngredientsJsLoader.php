<?php



session_start();
use app\models\IngredientsCategory;
use app\models\Ingredient;
require_once $_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php";

$stream = file_get_contents("php://input");
if($stream != null){
        //декодируем полученые данные

            $data = json_decode($stream)->data;
            // $user_id = $_SESSION["user"]["id"];
            $action = json_decode($stream)->action;
            // var_dump($data);
            // var_dump($stream);
            if($data == "all"){
                $recipe= Ingredient::getAllIngredients();
            }
            else{
                $recipe = match($action){
                    "getIngredientsByCategory"=>Ingredient::getIngredientsByCategory($data),
                    "IngredientBySech" => Ingredient::serch($data),
                    "delIngredient"=>Ingredient::delIngredient($data),
                    "getAllIngredientsCategorys"=>IngredientsCategory::getAllIngrCategory(),
                    "showDelMassIngredientsList"=>Ingredient::getIngerdientsByIds($data),
                    "delMassIngredients"=>Ingredient::delMassIngredients($data),
                    "getIngredient"=>Ingredient::getIngredientById($data),
                    "changeIngredientConfirm"=>Ingredient::changeIngredientValue($data->id,$data->name,$data->price_100g,$data->calory,$data->self_life_days,$data->categoryInAddIngredient),
                };
            }

            echo json_encode([
                "productInBasket"=>$recipe,
            ], JSON_UNESCAPED_UNICODE);


}
if(isset($_POST["name"])){
    Ingredient::addIngredient($_POST["name"],$_POST["price_100g"],$_POST["calory"],$_POST["self_life_days"],$_POST["categoryInAddIngredient"]);
    echo json_encode([
        "productInBasket"=>"",
    ], JSON_UNESCAPED_UNICODE);
}