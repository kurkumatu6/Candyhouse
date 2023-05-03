<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";

$title = "Админ статистика";
if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){
        $location = "statistics";
    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminStatistics.view.php";    
