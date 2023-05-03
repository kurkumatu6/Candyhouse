<?php

namespace app\models;
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;


class StatusOfOrder{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllStatuses(){
        $query = PDOConnection::make()->query("SELECT * FROM `statuses_of_orders`");
        return $query->fetchAll();
    }
    
    public static function addstatusOfOrder($name){
        $queryTry = PDOConnection::make()->prepare("SELECT * FROM statuses_of_orders WHERE status = :status");
        $queryTry->execute(["status"=>$name]);
        $category= $queryTry->fetch();
        if($category == null){
            $query= PDOConnection::make()->prepare("INSERT INTO `statuses_of_orders`(`id`, `status`) VALUES (NULL,:name)");
            $query->execute(["name"=>$name]);
            return true;
        }
        else{
            return false;
        }
    }

    public static function delOrderStatus($status_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `statuses_of_orders` WHERE id = :status_id");
        $query->execute(["status_id"=>$status_id]);
    }
}