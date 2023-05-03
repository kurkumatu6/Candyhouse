<?php

namespace app\models;
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";
require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/Client.php";
use App\base\PDOConnection;
use app\models\Client;
class Review{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllReviewsForProduct($id){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, clients.name as client, clients.email as email, products.name as product FROM `reviews` INNER JOIN clients ON clients.id = reviews.client_id INNER JOIN products ON products.id = reviews.product_id WHERE product_id =  :id");
        $query->execute(["id"=>$id]);
        return $query->fetchAll();
    }

    public static function addReview($content, $user_id,$product_id){
        $query = PDOConnection::make()->prepare("INSERT INTO `reviews` (`id`, `client_id`, `product_id`, `content`, `date_reviews`) VALUES (NULL,:client_id,:product_id,:content,:date_reviews)");
        $query->execute(["client_id"=>$user_id,'product_id'=>$product_id,'content'=>$content, 'date_reviews'=>date("Y-m-d")]);
    }

    public static function getAllReviews(){
        $query = PDOConnection::make()->query("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id");
        return $query->fetchAll();
    }

    public static function getReviewsByDateStart($dateStart){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.date_reviews > :dateStart");
        $query->execute(["dateStart"=>$dateStart]);
        return $query->fetchAll();
    }
    public static function getReviewsByDateEnd($dateEnd){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.date_reviews < :dateEnd");
        $query->execute(["dateEnd"=>$dateEnd]);
        return $query->fetchAll();
    }

    public static function getReviewsOnDateStartToDateEnd($dateStart, $dateEnd){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.date_reviews > :dateStart AND reviews.date_reviews < :dateEnd");
        $query->execute(["dateStart"=>$dateStart, "dateEnd"=>$dateEnd]);
        return $query->fetchAll();
    }

    public static function getReviewsByDateStartAndProdId($dateStart, $product_id){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.date_reviews > :dateStart AND reviews.product_id = :product_id");
        $query->execute(["dateStart"=>$dateStart, "product_id"=>$product_id]);
        return $query->fetchAll();
    }
    public static function getReviewsByDateEndAndProdId($dateEnd, $product_id){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.date_reviews < :dateEnd AND reviews.product_id = :product_id");
        $query->execute(["dateEnd"=>$dateEnd , "product_id"=>$product_id]);
        return $query->fetchAll();
    }

    public static function getReviewsOnDateStartToDateEndAndProdId($dateStart, $dateEnd, $product_id){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.date_reviews > :dateStart AND reviews.date_reviews < :dateEnd AND reviews.product_id = :product_id");
        $query->execute(["dateStart"=>$dateStart, "dateEnd"=>$dateEnd, "product_id"=>$product_id]);
        return $query->fetchAll();
    }

    public static function getReviewById($review_id){
        $query = PDOConnection::make()->prepare("SELECT reviews.*, products.name as product, clients.email as email FROM `reviews` INNER JOIN products ON products.id = reviews.product_id INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.id = :review_id");
        $query->execute(["review_id"=>$review_id]);
        return $query->fetch();
    }

    public static function delReview($review_id, $warning, $reason_warning){
        if($warning){
            $querySelectUser = PDOConnection::make()->prepare("SELECT client_id FROM `reviews` WHERE id = :review_id");
            $querySelectUser->execute(["review_id"=>$review_id]);
            $userId= $querySelectUser->fetch()->client_id;
           Client::setWarningOrBlockUser($userId, $reason_warning);
        }
        $query = PDOConnection::make()->prepare("DELETE FROM `reviews` WHERE id = :review_id");
        $query->execute(["review_id"=>$review_id]);
    }

    public static function getUserwarning($review_id){
        $query = PDOConnection::make()->prepare("SELECT clients.warning, clients.id FROM `reviews` INNER JOIN clients ON clients.id = reviews.client_id WHERE reviews.id = :review_id");
        
        $query->execute(["review_id"=>$review_id]);
        // var_dump($query->fetch());
        return $query->fetch();
    }
}