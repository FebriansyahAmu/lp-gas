<?php

namespace App\Models;

use App\Core\Database;

class Alamat{
    protected static $table = 'ec_alamat';

    public static function createAlamat($data) {
        try {
            $db = Database::getConnection();
    
            // Cek apakah user sudah memiliki alamat
            $stmt = $db->prepare("SELECT COUNT(*) as count FROM " . self::$table . " WHERE id_user = ? AND deleted_at IS NULL");
            if (!$stmt) {
                throw new \Exception("Failed to create statement", $db->error);   
            }
    
            $stmt->bind_param("i", $data['userId']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
    
            // Set status berdasarkan hasil pengecekan
            $status = ($row['count'] > 0) ? 'secondary' : 'utama';
    
            // Masukkan data alamat baru
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (id_user, Detail_alamat, Description, Status) VALUES(?,?,?,?)");
            if (!$stmt) {
                throw new \Exception("Failed to create statement", $db->error);   
            }
    
            $stmt->bind_param("isss", $data['userId'], $data['Detail_alamat'], $data['Description'], $status);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Failed to execute query", $stmt->error);
            }
    
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    

    public static function getAlamatByUsersId($userId){
        try{
            $db = Database::getConnection();

            $stmt = $db->prepare("SELECT id_Alamat, Detail_alamat, Description, Status FROM " . self::$table . " WHERE id_user = ? AND deleted_at IS NULL");
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

            $stmt = $db->prepare("SELECT Detail_Alamat, Description FROM " . self::$table . " WHERE id_Alamat = ? AND id_user = ? AND deleted_at IS NULL");
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

            $stmt = $db->prepare("UPDATE " . self::$table . " SET deleted_at = NOW() WHERE id_Alamat = ? AND id_user = ?");
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


    public static function getAlamatCart($userId){
        try{
            $status = 'utama';
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT id_Alamat, Detail_alamat, Description FROM " . self::$table . " WHERE id_user = ? AND status = ? AND deleted_at IS NULL");

            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('is', $userId, $status);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            };

            return $result->fetch_assoc();
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }


    private static function updateToSec($userId){
        try{
            $db = Database::getConnection();
            $status = 'secondary';
            $stmt = $db->prepare("UPDATE " . self::$table . " SET Status = ? WHERE id_user = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param("si", $status, $userId);
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

    public static function pilihAlamatUtama($userId, $id){
        try{
            self::updateToSec($userId);
            $db = Database::getConnection();
            $status = 'utama';
            $stmt = $db->prepare("UPDATE " . self::$table . " SET Status = ? WHERE id_Alamat = ? AND id_user = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param("sii", $status, $id, $userId);
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