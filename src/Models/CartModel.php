<?php

namespace App\Models;

use App\Core\Database;

class CartModel{
    protected static $table = 'ec_cart';

    public static function findCart($userId, $id_gas){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT Qty FROM " . self::$table . " WHERE user_id = ? AND id_gas = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('ii', $userId, $id_gas);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows > 0){
                $stmt->bind_result($qty);
                $stmt->fetch();
                return $qty;
            }

            return false;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return null;
        }
    }

    public static function addToCart($data){
        try{
            $db = Database::getConnection();
            $db->begin_transaction();

            $getData = self::findCart($data['user_id'], $data['id_gas']);

            if($getData !== false){
                $updateStmt = $db->prepare("UPDATE " . self::$table . " SET Qty = ? WHERE user_id = ? AND id_gas = ?");
                if(!$updateStmt){
                    throw new \Exception("Failed to prepare statement", $db->error);
                }

                $updateStmt->bind_param('iii', $data['qty'], $data['user_id'], $data['id_gas']);
                $res = $updateStmt->execute();

                if(!$res){
                    throw new \Exception("Failed to execute query", $db->error);
                }
            }else{
                $insertStmt = $db->prepare("INSERT INTO " . self::$table . " (user_id, id_gas, Jenis_gas, harga_unit, Qty) VALUES(?, ?, ?, ?, ?)");
                if(!$insertStmt){
                    throw new \Exception("Failed to prepare statement", $db->error);
                }

                $insertStmt->bind_param('iisii', $data['user_id'], $data['id_gas'], $data['jenis_gas'], $data['harga_gas'], $data['qty']);
                $res = $insertStmt->execute();
                if(!$res){
                    throw new \Exception("Failed to execute query ", $db->error);
                }
            }
            $db->commit();
            return true;
        }catch(\Exception $e){
            $db->rollback();
            error_log($e->getMessage());
            return false;
        }
    }
}