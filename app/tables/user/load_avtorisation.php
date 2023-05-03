<?php
session_start();
use app\models\Client;
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
if(isset( $_POST["okBtn"])){
    $login = $_POST["login"];
    $password = $_POST["password"];
    $client = Client::clientAuth($login,$password);
    if($client){
        if($client->is_blocked){
            $_SESSION["errors"]["auth"]= "Ваш акаунт заблокирован";
            header("Location: /app/tables/user/auth.php");
        }
        else{
            $_SESSION["user"]["id"] = $client->id;
            $_SESSION["user"]["name"] = $client->name;
            $_SESSION["auth"]= true;
            header("Location: /");
        }

    }
    else{
        $_SESSION["errors"]["auth"]= "Неверный логин или пароль";
        header("Location: /app/tables/user/auth.php");
    }
}
