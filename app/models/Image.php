<?php

namespace app\models;

use App\base\PDOConnection;

class Image {
    private static function connect($config = CONFIG_CONNECTION){
        return PDOConnection::make($config);
    }

    public static function getAllImagesForProduct($id){
        $query = PDOConnection::make()->prepare("SELECT * FROM `images` WHERE product_id = :id");
        $query->execute(["id"=>$id]);
        return $query->fetchAll();
    }
    public static function getAllImages(){
        $query = PDOConnection::make()->query("SELECT * FROM `images`");
        return $query->fetchAll();
    }
    
    public static function getParam($array, $value){
        return implode(",", array_fill(0,count($array), $value)); //создание строки из массива
    }

    public static function addImagesForProduct($productId, $images){
        $imagestemp = [];
        foreach ($images as $image){
            if($image["tmp_name"]!=""){
                array_push( $imagestemp, $image);
            }
        }
        if(count($images)>0){
            $queryBaseAddDisc = "INSERT INTO `images`( `image`, `product_id`) VALUES ";
            $queryParamsAddDisc = "";
            $valuesAddDisc = [];
            $errorImageLoader = [];
            foreach ($imagestemp as $image){
                $image = ImageControls::addImage($image);
                if(!$image["error"]){
                    array_push($valuesAddDisc, $image["message"]);
                    array_push($valuesAddDisc,$productId);
                    $queryParamsAddDisc .= " (?,?)," ;
                }
                else{
                    array_push($errorImageLoader, $image["message"]);
                    array_push($valuesAddDisc, "");
                }
                
                // array_push($valuesAddDisc,$discript["stepId"]);
                // array_push($valuesAddDisc,$discript["discript"]);

    
            }
            if(count($valuesAddDisc)>0){
                $queryParamsAddDisc = chop($queryParamsAddDisc,",");
                $query = PDOConnection::make()->prepare($queryBaseAddDisc . $queryParamsAddDisc);
                $query->execute($valuesAddDisc);
            }
                      //var_dump($valuesAddDisc);

            if(!empty($errorImageLoader)){
                return $errorImageLoader;
            }
        }

    }

    public static function delAllImagesForProduct($productId){
        $query = PDOConnection::make()->prepare(" SELECT * FROM `images` WHERE images.product_id = :product_id");
        $query->execute(["product_id"=>$productId]);
        $images = $query->fetchAll();
        foreach($images as $image){
            ImageControls::deleteImage($image->image);
        }
    }
    public static function deleteOneImage($imageId){
        $query = PDOConnection::make()->prepare(" SELECT * FROM `images` WHERE images.id = :id");
        $query->execute(["id" => $imageId]);
        $image = $query->fetch();
        ImageControls::deleteImage($image->image);
    }
    public static function changeImage($productId, $imageId, $newImage){
        $addimage= ImageControls::addImage($newImage);
        var_dump($addimage);
        if(!$addimage["error"]){
            self::deleteOneImage($imageId);
            $query = PDOConnection::make()->prepare("UPDATE `images` SET `image`=:image WHERE `id`=:id AND `product_id`=:product_id");
            $query->execute(["id"=>$imageId, "product_id"=>$productId, "image"=>$addimage["message"]]);
        }

    }

    public static function delMassImages ($imageIds){
        $queryTextBase = "DELETE FROM `images` WHERE id IN ( ";
        $queryTextParam = self::getParam($imageIds, "?");
        $queryTextEnd = " );";
        $query = PDOConnection::make()->prepare($queryTextBase.$queryTextParam.$queryTextEnd);
        $query->execute($imageIds);
    }
}