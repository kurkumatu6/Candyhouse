<?php

namespace app\models;
session_start();

require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/ProductInOrder.php";
require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/RecipesInOrder.php";
require_once $_SERVER["DOCUMENT_ROOT"]. "/app/models/Client.php";
use App\base\PDOConnection;
use app\models\ProductInOrder;
use app\models\RecipesInOrder;
use app\models\Client;
class Order{
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }
    public static function createOrder($user_id,$delivery_addres,$addressee_phone,$discription,$date_of_issue_of_order){
        $busket = Basket::getUserBusket($user_id);
        $busketRecipes = Basket::getUserBusketRecipe($user_id);
        $conn = PDOConnection::make();
        // var_dump($delivery_addres);
        $price_order =0;
        foreach($busket as $prod){
            $price_order += (int)$prod->count * (float)$prod->price;
        }
        foreach($busketRecipes as $Recipe){
            $price_order += (int)$Recipe->count * (float)$Recipe->price;
        }
        $_SESSION["bb"]=$busketRecipes ;
        try{
            $conn->beginTransaction();
            $orderId = self::add($user_id, $delivery_addres,$price_order,$addressee_phone,$discription,$date_of_issue_of_order,$conn);
            ProductInOrder::addProducts($busket, $orderId, $conn);
            RecipesInOrder::addRecipes($busketRecipes,$orderId, $conn);
            // Product::changeCount($backet, $conn);
            Basket::clear($user_id,$conn);
            $conn->commit();
            return true;
        }
        catch(\PDOException $error){
            $conn->rollBack();
            echo("ошибка " .  $error->getMessage());
            return false;
        }
    }
    public static function add ($user_id,$delivery_addres,$price_order,$addressee_phone,$discription,$date_of_issue_of_order, $conn=null ){
        $conn = $conn??PDOConnection::make();
        $_SESSION["dd"]=$addressee_phone;
        $query = $conn->prepare("INSERT INTO `orders`(`id`, `delivery_addres`, `order_date`, `price_order`, `client_id`, `status_of_order_id`, `addressee_phone`, `discription`, `date_of_issue_of_order`) VALUES (NULL,:delivery_addres,:order_date,:price_order,:client_id,1,:addressee_phone,:discription,:date_of_issue_of_order)");
        $query->execute(["delivery_addres"=>$delivery_addres,"order_date"=>date("Y-m-d H:i:s"),"price_order"=>$price_order,"client_id"=>$user_id,"addressee_phone"=>"89095897754","discription"=>$discription,"date_of_issue_of_order"=>$date_of_issue_of_order]);
        return $conn->lastInsertId();
    }
    public static function getAllOrdersByUser($user_id){
        $query = PDOConnection::make()->prepare("SELECT orders.*, statuses_of_orders.status as status, (SELECT SUM(count) FROM products_in_orders WHERE products_in_orders.order_id = orders.id ) as count, (
            IFNULL((SELECT SUM(products_in_orders.count * 
                        (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
             FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
            
            +
            IFNULL((SELECT SUM(recipes_in_orders.count * 
                            (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
                FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  ) as sum, (SELECT SUM(count) FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id) as countRic FROM `orders` INNER JOIN statuses_of_orders ON orders.status_of_order_id = statuses_of_orders.id WHERE  client_id = :client_id");
        $query->execute(["client_id"=>$user_id]);
        return $query->fetchAll();
    }

    public static function getAllProductsInOrder($order_id){
        $query = PDOConnection::make()->prepare("SELECT products_in_orders.*, (SELECT image FROM images WHERE images.product_id = products.id LIMIT 1) as image, products.name as name, products.price as price, categories.category as category FROM `products_in_orders` INNER JOIN products ON products.id = products_in_orders.product_id INNER JOIN categories ON products.category_id = categories.id  WHERE order_id = :order_id");
        $query->execute(["order_id"=>$order_id]);
        return $query->fetchAll();
    }

    public static function getAllOrders(){
        $query = PDOConnection::make()->query("SELECT orders.*, statuses_of_orders.status as status, (SELECT SUM(count) FROM products_in_orders WHERE products_in_orders.order_id = orders.id ) as count, (
            IFNULL((SELECT SUM(products_in_orders.count * 
                        (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
             FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
            
            +
            IFNULL((SELECT SUM(recipes_in_orders.count * 
                            (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
                FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  ) as sum, (SELECT SUM(count) FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id) as countRic FROM `orders` INNER JOIN statuses_of_orders ON orders.status_of_order_id = statuses_of_orders.id");
        return $query->fetchAll();
    }

    public static function getOrdersByStatus($statusId ){
        $query = PDOConnection::make()->prepare("SELECT orders.*, statuses_of_orders.status as status, (SELECT SUM(count) FROM products_in_orders WHERE products_in_orders.order_id = orders.id ) as count, (
            IFNULL((SELECT SUM(products_in_orders.count * 
                        (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
             FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
            
            +
            IFNULL((SELECT SUM(recipes_in_orders.count * 
                            (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
                FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  ) as sum, (SELECT SUM(count) FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id) as countRic FROM `orders` INNER JOIN statuses_of_orders ON orders.status_of_order_id = statuses_of_orders.id WHERE  orders.status_of_order_id = :status_id");
        $query->execute(["status_id"=>$statusId]);
        return $query->fetchAll();
    }

    public static function changeOrderStatus($orderId, $statusId){
        $query = PDOConnection::make()->prepare("UPDATE `orders` SET `status_of_order_id`=:statusId WHERE id = :orderId");
        $query->execute(["statusId"=>$statusId, "orderId"=>$orderId]);
    }

    public static function changeStatusToCensel($orderId, $statusId, $user_id, $warning,$reason_warning, $recipesIds, $reason_cansel){
        if($warning){
            Client::setWarningOrBlockUser($user_id, $reason_warning);
        }
        if(count( $recipesIds)>0){
            Recipe::delMassRecipe($recipesIds);
        }

        $query = PDOConnection::make()->prepare("UPDATE `orders` SET `status_of_order_id`=:statusId, `reason_censel`=:reason_censel WHERE id = :orderId");
        $query->execute(["statusId"=>$statusId, "orderId"=>$orderId, "reason_censel"=>$reason_cansel]);
    } 

    public static function getOrderInfoById($orderId){
        $query = PDOConnection::make()->prepare("SELECT orders.*, statuses_of_orders.status as status, (SELECT SUM(count) FROM products_in_orders WHERE products_in_orders.order_id = orders.id ) as count, (
            IFNULL((SELECT SUM(products_in_orders.count * 
                        (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
             FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
            
            +
            IFNULL((SELECT SUM(recipes_in_orders.count * 
                            (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
                FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  ) as sum , (SELECT SUM(count) FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id) as countRic FROM `orders` INNER JOIN statuses_of_orders ON orders.status_of_order_id = statuses_of_orders.id WHERE  orders.id = :orderId");
        $query->execute(["orderId"=>$orderId]);
        return $query->fetch();
    }

    public static function getCountOrdersByLastMonth(){
        $query = PDOConnection::make()->query("SELECT COUNT(id) as count FROM `orders` WHERE orders.order_date > DATE_SUB( CURRENT_DATE, INTERVAL 1 MONTH)");
        return $query->fetch();
    }

    public static function getAllOrdersLimit6(){
        $query = PDOConnection::make()->query("SELECT orders.*, statuses_of_orders.status as status, (SELECT SUM(count) FROM products_in_orders WHERE products_in_orders.order_id = orders.id ) as count, (
            IFNULL((SELECT SUM(products_in_orders.count * 
                        (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
             FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
            
            +
            IFNULL((SELECT SUM(recipes_in_orders.count * 
                            (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
                FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  ) as sum, (SELECT SUM(count) FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id) as countRic FROM `orders` INNER JOIN statuses_of_orders ON orders.status_of_order_id = statuses_of_orders.id ORDER BY id DESC LIMIT 6");
        return $query->fetchAll();
    }

    public static function getCountOrdersFromDate($date){
        $query = PDOConnection::make()->prepare("SELECT COUNT(id) as count FROM `orders` WHERE orders.order_date = :order_date");
        $query->execute(["order_date"=>$date]);
        return $query->fetch();
    }

    public static function getUserWarning($order_id){
        $query = PDOConnection::make()->prepare("SELECT clients.warning, clients.id FROM `orders` INNER JOIN clients ON clients.id = orders.client_id WHERE orders.id = :order_id");
        
        $query->execute(["order_id"=>$order_id]);
        // var_dump($query->fetch());
        return $query->fetch();
    }

    public static function setAllDateOfmanufactures($prodsDates, $ricDates, $orderId){
        ProductInOrder::setDateOfManufacture($prodsDates);
        RecipesInOrder::setDateOfManufacture($ricDates);
        self::changeOrderStatus($orderId, 3);
    }

    public static function getMoneyByDates($dateStart, $dateEnd){
        if($dateStart == ""){
            $dateStart = "1970-01-01";
        }
        if($dateEnd == ""){
            $dateEnd = date("Y-m-d");
        }
        $query = PDOConnection::make()->prepare("SELECT SUM( (
            IFNULL((SELECT SUM(products_in_orders.count * 
                        (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
             FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
            
            +
            IFNULL((SELECT SUM(recipes_in_orders.count * 
                            (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
                FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  )) as sum, order_date FROM `orders` INNER JOIN statuses_of_orders ON statuses_of_orders.id = orders.status_of_order_id WHERE orders.order_date > :start_date AND orders.order_date < :end_date AND statuses_of_orders.status = 'Выполнен' GROUP BY order_date");
        $query->execute(["start_date"=>$dateStart,"end_date"=>$dateEnd]);
        return $query->fetchAll();
    }
}
// "SELECT (
//     IFNULL((SELECT SUM(products_in_orders.count * 
//                 (SELECT price FROM products WHERE products_in_orders.product_id = products.id)) 
//      FROM products_in_orders WHERE products_in_orders.order_id = orders.id),0)
    
//     +
//     IFNULL((SELECT SUM(recipes_in_orders.count * 
//                     (SELECT recipes.price FROM recipes WHERE recipes_in_orders.recipe_id = recipes.id)) 
//         FROM recipes_in_orders WHERE recipes_in_orders.order_id = orders.id), 0)  ) as sum 