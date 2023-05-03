<?php



session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
use app\models\Order;
// var_dump($_POST);
// $_SESSION["gg"] = $_POST;
// if(isset($_POST["createOrderBtn"])){
    $user_id = $_SESSION["user"]["id"];
    Order::createOrder($user_id, $_POST["adress"],$_POST["phone"],$_POST["text"],$_POST["date"]);

    echo json_encode([
        "productInBasket"=>""
    ], JSON_UNESCAPED_UNICODE);

// }
// header("Location: /app/tables/user/profile.php");
