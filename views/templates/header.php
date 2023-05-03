<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title??"Document"?></title>
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/Logo.png">
    <link rel="stylesheet" href="/assets/css/syle.css">
    <link rel="shortcut icon" href="/assets/images/Logo.png" type="image/png">
      <script src="/assets/js/headerFooter.js" defer></script>

</head>
<body>
<header>
        <div class="nav_logo">
            <img src="/assets/images/Logo.png" alt="" id="logo">
            <a id= "catalog" href="/">Каталог</a>
            <a id="constructor" href="/app/tables/recipes/construct.php">Конструктор</a>
            <a id="about" href="/app/about.php">О нас</a>
        </div>
        <?php if(isset($_SESSION["auth"]) && $_SESSION["auth"]):?>
        <div class="buttons">
            <a href="/app/tables/recipes/recipes.php">Мои рецепты</a>
            <a href="/app/tables/busket/busket.php">Корзина</a>
            <a href="/app/tables/user/profile.php"><?=$_SESSION["user"]["name"]??""?></a>
            <a href="/app/tables/user/logOut.php">Выйти</a>
        </div>
        <?php else:?>
        <div class="buttons">
            <a href="/app/tables/user/auth.php">Вход</a>
            <a href="/app/tables/user/registration.php">Регистрация</a>
        </div>
        <?php endif?>

    </header>
