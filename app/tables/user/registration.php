<?php
session_start();
// require_once $_SERVER["DOCUMENT_ROOT"]. "/core/connect.php";
$title = "Регистрация";
require_once $_SERVER["DOCUMENT_ROOT"]. "/views/tables/user/registration.view.php";

unset($_SESSION["errors"]);
unset($_SESSION["save"]);