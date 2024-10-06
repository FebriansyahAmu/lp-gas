<?php

namespace App\Models;

use App\Core\Database;

class Alamat{
    protected static $table = 'ec_alamat';

    public static function createAlamat($data){
        try{
            $db = Database::getConnection();

            $status = 'secondary';
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (id_user, Detail_alamat, Description, Status) VALUES(?,?,?,?)");
            if(!$stmt){
                throw new \Exception("Failed to create statement", $db->error);   
            }

            $stmt->bind_param("isss", $data['userId'], $data['Detail_alamat'], $data['Description'], $status);
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

            $stmt = $db->prepare("SELECT id_Alamat, Detail_alamat, Description, Status FROM " . self::$table . " WHERE id_user = ?");
            if(!$stmt){
                throw new \Exception("Failed to creaete statement", $db->error);
            }

            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result  = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to create statement", $stmt->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
    
    public static function getAlamatUID($id, $userId){
        try{
            $db = Database::getConnection();

            $stmt = $db->prepare("SELECT Detail_Alamat, Description FROM " . self::$table . " WHERE id_Alamat = ? AND id_user = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param("ii", $id, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return $result->fetch_assoc();

        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function putAlamatByUID($data){
        try{
            $db = Database::getConnection();
            
            $stmt = $db->prepare("UPDATE " . self::$table . " SET Detail_alamat = ?, Description = ? WHERE id_Alamat = ? AND id_user = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement: " . $db->error);
            }
    
            // Perbaiki urutan parameter dan pengetikan
            $stmt->bind_param("ssii", $data['Detail_alamat'], $data['Description'], $data['idAlamat'], $data['iduser']);
            
            $result = $stmt->execute();
            if(!$result){
                throw new \Exception("Failed to execute query: " . $stmt->error);
            }
    
            return true;
        } catch(\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public static function deleteAlamatByUID($id, $userId){
        try{
            $db = Database::getConnection();

            $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id_Alamat = ? AND id_user = ?");
            if(!$stmt){
                throw new \Exception("Failed to create statement", $db->error);
            }

            $stmt->bind_param("ii", $id, $userId);
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
    


}