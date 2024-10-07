<?php

namespace App\Models;

use App\Core\Database;

class CartModel{
    protected static $table = 'ec_cart';
    protected static $tb_gas = 'ec_gas';
    protected static $tb_user = 'ec_user';

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

    public static function getallCartUID($userId){
        try{    
            $db = Database::getConnection();
            $stmt = $db->prepare("
                SELECT cart.cart_id, cart.id_gas, cart.Jenis_gas, cart.harga_unit, cart.Qty, gas.Stok, gas.foto_gas
                FROM ". self::$table ." AS cart
                LEFT JOIN " . self::$tb_gas . " AS gas  ON gas.id_gas = cart.id_gas
                LEFT JOIN " . self::$tb_user ." AS user ON user.user_id = cart.user_id
                WHERE cart.user_id = ?
            ");

            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new \Exception("failed to execute query", $stmt->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
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

    public static function deleteCartByID($id, $userId){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE cart_id = ? AND user_id = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('ii', $id, $userId);
            $res = $stmt->execute();
            if(!$res){
                throw new \Exception("Failed to execute query", $db->error);
            }
            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
}