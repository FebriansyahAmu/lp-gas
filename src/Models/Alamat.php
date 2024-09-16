<?php

namespace App\Models;

use App\Core\Database;

class Alamat{
    protected static $table = 'ec_alamat';

    public static function createAlamat($data){
        try{
            $db = Database::getConnection();

            $stmt = $db->prepare("INSERT INTO " . self::$table . " (id_user, Detail_alamat, Description) VALUES(?,?,?)");
            if(!$stmt){
                throw new \Exception("Failed to create statement", $db->error);   
            }

            $stmt->bind_param("iss", $data['id_user'], $data['Detail_alamat'], $data['Description']);
            $success = $stmt->execute();
            if(!$success){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getAlamatByUsersId($userId){
        try{
            $db = Database::getConnection();

            $stmt = $db->prepare("SELECT id_Alamat, Detail_alamat, Description FROM " . self::$table . " WHERE id_user = ?");
            if(!$stmt){
                throw new \Exception("Failed to creaete statement", $db->error);
            }

            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result  = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to create statement", $stmt->error);
            }

            return $result->fetch_assoc();
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }


}