<?php

namespace app\models;

// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
use App\base\PDOConnection;

class ProductInOrder{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function addProducts($busket, $order_id, $conn){
        // var_dump($busket);
        $conn = $conn??PDOConnection::make();
        $queryBase = "INSERT INTO products_in_orders (order_id, product_id, count) VALUES";
        $queryParams = self::getParam($busket, "(?,?,?)");
        $values = [];
        foreach ($busket as $product){
            array_push($values,$order_id);
            array_push($values,$product->product_id);
            array_push($values,$product->count);
        }
        if(count($values) >0){
            $query = $conn->prepare($queryBase . $queryParams);
            $query->execute($values);
        }

    }
    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }
    public static function getCountProductInOrder($product_id){
        $query = PDOConnection::make()->prepare("SELECT COUNT(product_id) as count FROM `products_in_orders` INNER JOIN orders ON orders.id = products_in_orders.order_id WHERE product_id = :product_id AND orders.order_date > DATE_SUB( CURRENT_DATE, INTERVAL 1 MONTH);");
        $query->execute(['product_id'=> $product_id]);
        return $query->fetch();
    }

    public static function getAllProductInOrder($order_id){
        
    }

    public static function getCountProductsInOrdersByDates($dateStart, $dateEnd){
        // var_dump(["start_date"=>$dateStart,"end_date"=>$dateEnd]);
        if($dateStart == ""){
            $dateStart = "1970-01-01";
        }
        if($dateEnd == ""){
            $dateEnd = date("Y-m-d");
        }
        // var_dump(["start_date"=>$dateStart,"end_date"=>$dateEnd]);
        $query = PDOConnection::make()->prepare("SELECT products.name, SUM(products_in_orders.count) as data FROM `products_in_orders` INNER JOIN orders ON orders.id =products_in_orders.order_id INNER JOIN products ON products.id = products_in_orders.product_id WHERE orders.order_date > :start_date AND orders.order_date < :end_date GROUP BY products_in_orders.product_id");
        $query->execute(["start_date"=>$dateStart,"end_date"=>$dateEnd]);
        return $query->fetchAll();
    }

    public static function setDateOfManufacture($prodsDates){
        $query = PDOConnection::make()->prepare("UPDATE `products_in_orders` SET `date_of_manufacture` = :date_of_manufacture WHERE products_in_orders.product_id = :product_id AND products_in_orders.order_id = :order_id");
        
        foreach($prodsDates as $prod){
            // var_dump(["date_of_manufacture"=>$prod->date,"product_id"=>$prod->idProd,"order_id"=>$prod->orderId]);
            $query->execute(["date_of_manufacture"=>$prod->date,"product_id"=>$prod->idProd,"order_id"=>$prod->orderId]);
        }
    }
    public static function productPopulariti($dateStart, $dateEnd, $product_id){
        if($dateStart == ""){
            $dateStart = "1970-01-01";
        }
        if($dateEnd == ""){
            $dateEnd = date("Y-m-d");
        }
        $query = PDOConnection::make()->prepare("SELECT SUM(products_in_orders.count) as count, order_date FROM orders INNER JOIN products_in_orders ON products_in_orders.order_id = orders.id WHERE products_in_orders.product_id = :product_id AND orders.order_date > :start_date AND orders.order_date < :end_date GROUP BY order_date");
        $query->execute(["start_date"=>$dateStart,"end_date"=>$dateEnd, "product_id"=>$product_id]);
        return $query->fetchAll();
    }

}