<?php

namespace App\Models;

use App\Core\Database;

class CartModel{
    protected static $table = 'ec_cart';

    public static function addToCart($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare('INSERT INTO '. self::$table . ' (user_id, id_gas, Jenis_gas, harga_unit, Qty) VALUES(?, ?, ?, ?, ?)');
            if(!$stmt){
                throw new \Exception('Failed to prepare statement', $db->error);
            }

            $stmt->bind_param('iisii', $data['user_id'], $data['id_gas'], $data['jenis_gas'], $data['harga_gas'], $data['qty']);
            $res = $stmt->execute();
            if(!$res){
                throw new \Exception('Failed to execute query', $stmt->error);
            }

            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
}