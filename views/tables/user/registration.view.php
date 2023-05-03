<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
    <main>
        <div class="bg">
            <div class="form_wrapper">
                <h1>Регистрация</h1>
                <form action="load_registration.php" class="auth_form" method="POST">

                    <label for="" class="labels">Email</label>
                    <input class="authRegInputStyle" type="text" name="login" value="<?=$_SESSION["save"]["login"]??""?>">
                    <p style="display: <?=empty($_SESSION["errors"])?"none":"block" ?>"><?=$_SESSION["errors"]["void"]["login"]??""?><?=$_SESSION["errors"]["replay"]["login"]??""?><?=$_SESSION["errors"]["login"]??""?></p>
                    <label for="" class="labels">Пароль:</label>
                    <input class="authRegInputStyle" type="password" name="password">
                    <p style="display: <?=empty($_SESSION["errors"])?"none":"block" ?>"><?=$_SESSION["errors"]["void"]["password"]??""?><?=$_SESSION["errors"]["password"]??""?><?=$_SESSION["errors"]["passwordValid"]??""?></p>
                    <label for="" class="labels">Повтор пароля:</label>

                    <input class="authRegInputStyle" type="password" name="password_valid">
                    <?= $_SESSION["errors"]["passwordValid"]??""?>
                    <label for="" class="labels" >Имя:</label>
                    <input class="authRegInputStyle" type="text" name="name" value="<?=$_SESSION["save"]["name"]??""?>">

                                      <p style="display: <?=empty($_SESSION["errors"])?"none":"block" ?>"><?=$_SESSION["errors"]["void"]["name"]??""?><?=$_SESSION["errors"]["name"]??""?></p>
                    <label for="" class="labels">Телефон:</label>
                    <input class="authRegInputStyle" type="text" name="phone" value="<?=$_SESSION["save"]["phone"]??""?>">
                    <p style="display: <?=empty($_SESSION["errors"])?"none":"block" ?>"><?=$_SESSION["errors"]["void"]["phone"]??""?><?=$_SESSION["errors"]["phone"]??""?></p>
                    <!-- <input type="text" name="role"> -->
                    <div class="flexRow">
                        <p class="text_centr">Я согласен на обработку персональных данных</p>
                        <input type="checkbox" name="" id="pefsoanalData" >
                    </div>
                    <button name="okBtn" id="okBtn" class="auth_complit reg_comp" disabled>Зарегистрироваться</button>
                </form>
                <p class="auth_ssl">У вас есть аккаунт? - <a href="/app/tables/user/auth.php">Авторизируйтесь</a></p>
            </div>
        </div>
    <script>
        document.querySelector("#pefsoanalData").addEventListener("change", function(e){
            document.querySelector("#okBtn").disabled = !e.currentTarget.checked
        })
    </script>
    </main>

    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>