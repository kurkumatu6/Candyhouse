<?php
session_start();
use app\models\Client;

require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
if(isset($_POST["okBtn"])){
    $login = $_POST["login"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $name=  $_POST["name"];
    $passwordValid= $_POST["password_valid"];
    // $role = $_POST["role"];
    $client ="";
}

if($login == ""){
    $_SESSION["errors"]["void"]["login"] ="Это поле недолжно быть пустым";
}
else{
    if(filter_var($login, FILTER_VALIDATE_EMAIL)){
        $login = filter_var($login, FILTER_SANITIZE_EMAIL);
        $client=Client::getClientForEmail($login);
        if($client != null){
            $_SESSION["errors"]["replay"]["login"] = "Пользователь с таким email уже зарегистрирован";
        }

    }
    else{
        $_SESSION["errors"]["login"] ="Введён неверный E-mail";
    }
}
if($password == ""){
    $_SESSION["errors"]["void"]["password"] ="Это поле недолжно быть пустым";
}
else{
    if(!preg_match("/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/",$password)){
        $_SESSION["errors"]["password"] ="Пароль должен быть не мение 6 силволов, включать в себя минимум одну заглавную букву, цифру";
    }
}
if($phone == ""){
    $_SESSION["errors"]["void"]["phone"] ="Это поле недолжно быть пустым";
}
else{
    if(!preg_match("/(8|\+7)(-| |)[0-9]{3}(-| |)[0-9]{3}(-| |)[0-9]{2}(-| |)[0-9]{2}/",$phone)){
        $_SESSION["errors"]["phone"] ="Телефон не верный";
    }
}
if($name == ""){
    $_SESSION["errors"]["void"]["name"] ="Это поле недолжно быть пустым";
}
else{
    if(!preg_match("/[A-ZА-ЯЁ]{1}[a-zа-яё]*/",$password)){
        $_SESSION["errors"]["name"] ="Имя должно начинаться с большой буквы";
    }
}
if($password === $passwordValid){

}
else {
    $_SESSION["errors"]["passwordValid"] ="Пароли не совпадают";
}
if(empty( $_SESSION["errors"])){
   Client::addClient($login, $password, $name, $phone); 
   $client=Client::getClientForEmail($login);
   $_SESSION["user"]["id"] = $client->id;
   $_SESSION["user"]["name"] = $client->name;
   $_SESSION["auth"]= true;
   header("Location: /");
}
else{
    $_SESSION["save"]["login"]= $login;
    $_SESSION["save"]["phone"]= $phone;
    $_SESSION["save"]["name"]= $name;
    header("Location: /app/tables/user/registration.php");
}



