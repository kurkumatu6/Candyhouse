<?php
use app\models\Client;
use app\models\StatusOfClient;
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
$title = "Админ клиенты";

if(isset($_SESSION["user"]["admin"])){
    if($_SESSION["user"]["admin"]){

        $location = "clients";
        $clients = Client::getAllClients();
        $statusesOfClients = StatusOfClient::getAllStatusesOfClient();
    }
    else{
        header("Location: /app/admin/adminAuth.php");
    }
}
else{
    header("Location: /app/admin/adminAuth.php");
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminClients.view.php";    