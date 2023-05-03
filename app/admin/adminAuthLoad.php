<?php
session_start();
use app\models\Admin;
use app\models\Client;

require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

Admin::addAdmin("KORAL", "Dtlmvtlm12");
if(isset($_POST["adminAuth"])){
    $admin = Admin::adminAuth($_POST["adminLogin"], $_POST["adminPassword"]);

    if($admin != null){
        $_SESSION["admin"]["auth"] = true;
        $_SESSION["user"]["admin"] = true;
        $_SESSION["user"]["login"] = $admin->login;
        header("Location: /app/admin/adminMain.php");
        $_SESSION["super"]["admin"] = $admin->super_admin;
    }
    else{
        $user=Client::clientAuth($_POST["adminLogin"], $_POST["adminPassword"]);
        if($user != null){
            $_SESSION["errors"]["authadmin"]="В доступе отказано";
        }
        else{
            $_SESSION["errors"]["authadmin"]="Неверный логин или пароль";
        }
        header("Location: /app/admin/adminAuth.php");
    }
}