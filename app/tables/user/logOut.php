<?php
session_start();
unset($_SESSION["auth"]);
unset($_SESSION["user"]);
header("Location: /");