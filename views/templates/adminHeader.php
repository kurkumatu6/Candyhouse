<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/adminStyle.css">
    <title><?=$title??"Document"?></title>
    <link rel="shortcut icon" href="/assets/images/png-clipart-google-docs-spreadsheet-computer-icons-google-sheets-microsoft-excel-excel-icon-template-blue.png" type="image/png">
</head>
<body>

<header class="adminHeader">
    <div class="ots">
    <div class="user">
        <h2>ROOT</h2>
        <h3>Admin login: <?=$_SESSION["user"]["login"]??""?></h3>
        <form action="/app/admin/adminLogOut.php">
            <button class="adminLogoutButton">Exit</button>
        </form>
    </div>
    </div>

    <hr>
    <div class="ots">
    <nav >
    <a href="/app/admin/adminMain.php" class="navBlock <?= $location == "main"?"select":""?>" >Главная</a>
    <a href="/app/admin/adminProduct.php" class="navBlock <?= $location == "products"?"select":""?>">Продукты</a>
    <a href="/app/admin/adminOrders.php" class="navBlock <?= $location == "orders"?"select":""?>">Заказы</a>
    <a href="/app/admin/adminIngredient.php" class="navBlock <?= $location == "ingredients"?"select":""?>">Ингредиенты</a>
    <a href="/app/admin/adminStatistics.php" class="navBlock <?= $location == "statistics"?"select":""?>">Статистика</a>
    <a href="/app/admin/adminReview.php" class="navBlock <?= $location == "reviews"?"select":""?>">Отзывы</a>
    <a href="/app/admin/adminClients.php" class="navBlock <?= $location == "clients"?"select":""?>">Клиенты</a>
    <a href="/app/admin/adminReferenceBooks.php" class="navBlock <?= $location == "referenc"?"select":""?>">Cправочники</a>
    </nav>
    </div>


</header>