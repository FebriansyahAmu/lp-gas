<?php

namespace App\Models;

use App\Core\Database;

class Ulasan{
    protected static $table = 'ec_review';
    protected static $table_user = 'ec_user';


    public static function createUlasan($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (user_id, rating, review_description) VALUES(?,?,?)");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('iis', $data['userId'], $data['rating'], $data['ulasan']);
            $result = $stmt->execute();
            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getDataUlasan(){
        try{    
            $db = Database::getConnection();
            $stmt = $db->prepare("
                    SELECT rating.rating, rating.review_description, user.Nama_lengkap
                    FROM " . self::$table ." AS rating
                    INNER JOIN " . self::$table_user . " AS user ON rating.user_id = user.user_id
            ");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
}