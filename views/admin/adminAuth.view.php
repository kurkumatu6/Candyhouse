<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/header.php"; ?>
<main id="adminAuth_main">
    <form action="/app/admin/adminAuthLoad.php" method="post">
        <label for="">Login</label>
        <input type="text" name="adminLogin">
        <label for="">Password</label>
        <input type="password" name="adminPassword">
        <button name="adminAuth">Войти как админ</button>
        <p class="error"><?=$_SESSION["errors"]["authadmin"]??""?></p>
    </form>
</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/templates/footer.php"; ?>