<?php

namespace app\models;

// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class Client{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function addClient($email, $password, $name, $phone){
        $query = PDOConnection::make()->prepare("INSERT INTO `clients`(`id`, `email`, `password`, `name`, `phone`, `warning`, `status_of_client_id`, `date_of_registration`) VALUES (NULL, :email,:password,:name,:phone, 0 , 4, :date_of_registration)");
        $query->execute(["email"=>$email,"password"=>password_hash($password, PASSWORD_DEFAULT),"name"=>$name,"phone"=>$phone,"date_of_registration"=>date("Y-m-d")]);
    }
    
    public static function getClientForEmail($email){
        $query = PDOConnection::make()->prepare("SELECT * FROM `clients` WHERE email = :email OR phone = :email");
        $query->execute(["email"=>$email]);
        return $query->fetch();
    }

    public static function clientAuth($email, $password){
        $client = self::getClientForEmail($email);
        if($client != null){
            if(password_verify($password, $client->password)){
                return $client;
            }
            else{
                return null;
            }
        }
    }

    public static function getClientForId($id){
        $query = PDOConnection::make()->prepare("SELECT clients.*, statuses_of_clients.status as status FROM `clients` INNER JOIN statuses_of_clients ON statuses_of_clients.id = clients.status_of_client_id WHERE clients.id = :id");
        $query->execute(["id"=>$id]);
        return $query->fetch();
    }

    public static function getAllClients(){
        $query = PDOConnection::make()->query("SELECT clients.*, statuses_of_clients.id as status_id , (SELECT COUNT(id) FROM orders WHERE orders.client_id = clients.id) as orderCount, statuses_of_clients.status as status FROM `clients` INNER JOIN statuses_of_clients ON statuses_of_clients.id = clients.status_of_client_id");
        return $query->fetchAll();
    }

    public static function setWarningOrBlockUser($userId, $reason_warning){
        $queryGetUserWarning = PDOConnection::make()->prepare("SELECT  `warning` FROM `clients` WHERE id = :user_id");
        $queryGetUserWarning->execute(["user_id"=>$userId]);
        $userWarning = $queryGetUserWarning->fetch()->warning;
        if($userWarning){
            $queryAddWarning = PDOConnection::make()->prepare("UPDATE `clients` SET `is_blocked`= 1, `reason_blocking` = :reason_warning WHERE id= :client_id");
            $queryAddWarning->execute(["client_id"=>$userId, "reason_warning"=>$reason_warning]);

        }
        else{
            $queryAddWarning = PDOConnection::make()->prepare("UPDATE `clients` SET `warning`= 1, `reason_warning` = :reason_warning WHERE id= :client_id");
            $queryAddWarning->execute(["client_id"=>$userId, "reason_warning"=>$reason_warning]);
        }

    }

    public static function getCountRegistrarionByTime($dateStart, $dateEnd){
        if($dateStart == ""){
            $dateStart = "1970-01-01";
        }
        if($dateEnd == ""){
            $dateEnd = date("Y-m-d");
        }
            // var_dump(["start_date"=>$dateStart, "end_date"=>$dateEnd]);
            $query = PDOConnection::make()->prepare("SELECT COUNT(id) as count, date_of_registration  FROM `clients` WHERE date_of_registration >= :start_date AND date_of_registration <= :end_date GROUP BY date_of_registration ");
            $query->execute(["start_date"=>$dateStart, "end_date"=>$dateEnd]);
       
        return $query->fetchAll();
    }

    public static function setClientStatusById($client_id, $status_id){
        $query = PDOConnection::make()->prepare("UPDATE `clients` SET `status_of_client_id`=:status_id WHERE id = :client_id");
        $query->execute(["status_id"=>$status_id,"client_id"=>$client_id]);

    }
}