<?php
use app\models\Review;
$reviews = "";
// var_dump($_POST);
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
if(isset($_POST["reviewsProduct"])){
    if($_POST["reviewsProduct"] == "all"){
        if( $_POST["startDate"] != '' && $_POST["endDate"] != ""){
            $reviews = Review::getReviewsOnDateStartToDateEnd($_POST["startDate"], $_POST["endDate"]);
        }
        elseif($_POST["startDate"] != ''){
            $reviews = Review::getReviewsByDateStart($_POST["startDate"]);
        }
        elseif($_POST["endDate"] != ""){
            $reviews = Review::getReviewsByDateEnd($_POST["endDate"]);
        }
        else{
            $reviews = Review::getAllReviews();
        }
    
    }
    else{
        if( $_POST["startDate"] != '' && $_POST["endDate"] != ""){
            $reviews = Review::getReviewsOnDateStartToDateEndAndProdId($_POST["startDate"],$_POST["endDate"],$_POST["reviewsProduct"]);
        }
        elseif($_POST["startDate"] != ''){
            $reviews = Review::getReviewsByDateStartAndProdId($_POST["startDate"],$_POST["reviewsProduct"]);
        }
        elseif($_POST["endDate"] != ""){
            $reviews = Review::getReviewsByDateEndAndProdId($_POST["endDate"], $_POST["reviewsProduct"]);
        }
        else{
            $reviews = Review::getAllReviewsForProduct($_POST["reviewsProduct"]);
        }
    }
    echo json_encode([
        "productInBasket"=>$reviews,
    ], JSON_UNESCAPED_UNICODE);
}
$stream = file_get_contents("php://input");
if($stream != null){
    //декодируем полученые данные

        $data = json_decode($stream)->data;
        // $user_id = $_SESSION["user"]["id"];
        $action = json_decode($stream)->action;
        // var_dump($data);
        // var_dump($stream);
        // var_dump($data);
            $recipe = match($action){
                "showReview"=>Review::getReviewById($data),
                "delReview"=>Review::delReview($data->review_id, $data->warning, $data->reason_warning),
                "getUserWarning"=>Review::getUserwarning($data),
            };

        echo json_encode([
            "productInBasket"=>$recipe,
        ], JSON_UNESCAPED_UNICODE);


}
