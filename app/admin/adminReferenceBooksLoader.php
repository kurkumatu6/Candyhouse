<?php
use app\models\Admin;
use app\models\IngredientsCategory;
use app\models\StatusOfClient;
use app\models\StatusOfOrder;
session_start();
use app\models\Category;
require_once $_SERVER["DOCUMENT_ROOT"]. "/bootstrap.php";
if(isset($_POST['addProdCategory'])){
    if(!Category::addCategory($_POST['addProdCategoryName'])){
        $_SESSION["error"]["addProdCategory"]= "Категория с таким названием уже существует";
    }
}
if(isset($_POST["addIngredientCategory"])){
    if(!IngredientsCategory::addCategory($_POST["addIngredientCategoryName"])){
        $_SESSION["error"]["addIngrCategory"]= "Категория с таким названием уже существует";
    }
}
if(isset($_POST["addClientsStatus"])){
    if(!StatusOfClient::addStatusOfClients($_POST["addClientsStatusName"])){
        $_SESSION["error"]["addClientStatus"]= "Такой статус уже существует";
    }
}
if(isset($_POST["addOrdersStatus"])){
    if(!StatusOfOrder::addstatusOfOrder($_POST["addOrdersStatusName"])){
        $_SESSION["error"]["addOrderStatus"]= "Такой статус уже существует";
    }
}
if(isset($_POST["addAdmin"])){
    if(!Admin::addAdmin($_POST["addAdminLogin"],$_POST["addAdminPassword"])){
        $_SESSION["error"]["addAdmin"]= "Администратор с таким логином уже существует";
    }
}
header("Location: /app/admin/adminReferenceBooks.php");