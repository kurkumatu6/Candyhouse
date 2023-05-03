<?php

namespace app\models;
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;


class StatusOfClient{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllStatusesOfClient(){
        $query = PDOConnection::make()->query("SELECT * FROM `statuses_of_clients`");
        return $query->fetchAll();
    }

    public static function addStatusOfClients($name){
        $queryTry = PDOConnection::make()->prepare("SELECT * FROM statuses_of_clients WHERE status = :status");
        $queryTry->execute(["status"=>$name]);
        $category= $queryTry->fetch();
        if($category == null){
            $query= PDOConnection::make()->prepare("INSERT INTO `statuses_of_clients`(`id`, `status`) VALUES (NULL,:name)");
            $query->execute(["name"=>$name]);
            return true;
        }
        else{
            return false;
        }
    }
    public static function getStatusById($status_id){
        $query = PDOConnection::make()->prepare("SELECT * FROM `statuses_of_clients` WHERE id = :status_id");
        $query->execute(["status_id"=>$status_id]);
        return $query->fetch();
    }
    public static function delClientStatus($status_id){
        $query = PDOConnection::make()->prepare("DELETE FROM `statuses_of_clients` WHERE id = :status_id");
        $query->execute(["status_id"=>$status_id]);
    }
}