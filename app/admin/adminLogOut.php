<?php
session_start();
unset($_SESSION["admin"]["auth"]);
unset($_SESSION["user"]["admin"]);
unset($_SESSION["user"]["login"]);
unset($_SESSION["super"]["admin"]);
header("Location: /app/admin/adminAuth.php");