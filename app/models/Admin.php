<?php 

namespace app\models;
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class Admin{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function adminAuth($login, $password){
        $query = PDOConnection::make()->prepare("SELECT * FROM `admins` WHERE login = :login");
        $query->execute(["login"=>$login]);
        $admin = $query->fetch();
        if(password_verify($password, $admin->password)){
            return $admin;
        } 
        else{
            return null;
        }
    }

    public static function addAdmin($login, $password){
        $queryTry = PDOConnection::make()->prepare("SELECT * FROM admins WHERE login = :login");
        $queryTry->execute(["login"=>$login]);
        $adm = $queryTry->fetch();
        if($adm == null){
            $query = PDOConnection::make()->prepare("INSERT INTO `admins`(`id`, `password`, `login`) VALUES (NULL,:password,:login)");
            $query->execute(["login"=>$login, "password"=>password_hash($password, PASSWORD_DEFAULT)]);
            return true;
        }
        else{
            return false;
        }

        
    }
}
