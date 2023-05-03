<?php
session_start();
$title = "Админ авторизация";
require_once $_SERVER["DOCUMENT_ROOT"] . "/views/admin/adminAuth.view.php"; 
unset($_SESSION["errors"]["authadmin"]);