<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/syle.css">
</head>

<body>

    <main>
        <div class="bg">
            <div class="form_wrapper">
                <h1>Вход</h1>
                <form class="auth_form" action="load_avtorisation.php" method="POST">

                    <label for="" class="labels">Email:</label>
                    <input class="authRegInputStyle" type="text" name="login">
                    <label for="" class="labels">Пароль:</label>
                    <input class="authRegInputStyle" type="password" name="password">
                    <p><?=$_SESSION["errors"]["auth"]??""?></p>
                    <button name="okBtn" class="auth_complit">Авторизоваться</button>
                </form>
                <p class="auth_ssl">У вас нет аккаунта? - <a href="registration.php">Зарегистрируйтесь</a></p>
            </div>
        </div>

    </main>
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>