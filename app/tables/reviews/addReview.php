<?php
session_start();
use app\models\Review;
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
$_SESSION["xx"]= $_POST;
// var_dump($_POST);
$contents = [];
$_SESSION["content"] = strip_tags($_POST["review"]);
// $_SESSION["prodid"] = $_POST["prodid"];
$badwords = ["хуй","пизд","далбо","долбо","уеб","хуе","хуя","пидо","пидр","оху","аху","залу","пезд","еба","еб", "бля"];
$pattern = "/\b[а-яё]*(".implode("|", $badwords).")[а-яё]*\b/ui";
$res = preg_replace($pattern, "ПЛОХОЕ СЛОВО", $_SESSION["content"]);
$errorcomment = "";

// var_dump($_SESSION["content"]);
// var_dump($res);

if ($res==$_SESSION["content"]) {

} else{
    $errorcomment = "неадекватный комментарий";
}

if (empty($_SESSION["content"])) {
    $errorcomment = "комментарий пустой";
} elseif (!preg_match("/.{15,}/", $_SESSION["content"])) {
    $errorcomment = "слишком маленький комментарий";
}
// var_dump( $errorcomment);
if ($errorcomment == "") {
    Review::addReview($_POST["review"], $_SESSION["user"]["id"], $_POST["product_id"]);
    echo json_encode([
        "productInBasket"=>"",
    ], JSON_UNESCAPED_UNICODE);
}
else{
    echo json_encode([
        "productInBasket"=>$errorcomment,
    ], JSON_UNESCAPED_UNICODE);
}
unset($_SESSION["errorsComment"]);
