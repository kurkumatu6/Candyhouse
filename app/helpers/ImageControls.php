<?php

namespace app\models;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/base/PDOConnection.php";

use App\base\PDOConnection;

class ImageControls
{
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }
    public static function addImage($file)
    {

        if($file["tmp_name"] != ""){
            $arrExtenstions = ["jpg", "jpeg", "png", "jfif", "webp"];
            $arrMimeTypes = ["image/jpg", "image/jpeg", "image/png", "image/jfif", "image/webp"];
            $tmpname = $file["tmp_name"];
            $name = $file["name"];
            $type = mime_content_type($tmpname);
            $path_parts = pathinfo($name);
            if (in_array($type, $arrMimeTypes)) {
                if (in_array($path_parts['extension'], $arrExtenstions)) {
                    $nameInServer =  time() . "_" . preg_replace("/[\-&\d_#]/", "", $name);
                    if (move_uploaded_file($tmpname, $_SERVER["DOCUMENT_ROOT"] . "/upload/" . $nameInServer)) { //возвращает тру или фолс в зависимости получилось ли загрузить файл во второй атрибут нужно писать новое имя файла
                        return ["error" => false,"message"=> $nameInServer];
                    } else {
                        return ["error" => true,"message"=> "неизвестная ошибка, файл не загружен 2"];
                    }
                } else {
                    return ["error" => true,"message"=> "расширение файла должно быть: " . implode(", ", $arrExtenstions)] ;
                }
            } else {
                return ["error" => true,"message"=> "тип файла должен быть: " . implode(", ", $arrMimeTypes)] ;
            }
        }

    }

    public static function deleteImage($name){
        
        unlink($_SERVER["DOCUMENT_ROOT"]. "/upload/" . $name);
    }
}

