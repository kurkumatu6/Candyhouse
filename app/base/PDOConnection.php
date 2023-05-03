<?php
namespace App\base;



class PDOConnection{
    public static function make($config = CONFIG_CONNECTION){
       return new \PDO("mysql:host=".$config["host"].";dbname=".$config["dbname"],
       $config["username"],
       $config["password"],
       $config["config"] );
    }
}