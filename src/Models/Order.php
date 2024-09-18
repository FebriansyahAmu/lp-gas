<?php

namespace App\Models;

use App\Models\ProductModel;
use App\Core\Database;

Class Order{
    protected static $table = 'ec_order';
    protected static $tb_gas = 'ec_gas';
 
    public static function  validateOrder($data){
        $errors = [
            'invalid_product_id' => 'Id gas tidak valid',
            'invalid_quantity' => 'Kuantitas harus lebih dari 0 dan valid',
            'product_not_found' => 'Product tidak ditemukan',
            'quantity_exceeds_stock' => 'Kuantitas melebihi stok yang tersisa',
            'invalid_total_price' => 'Total harga tidak sesuai'
        ];

        try{
            //validasi id gas
            if(!$data['productId'] || !is_int($data['productId'])){
                throw new \Exception($errors['invalid_product_id']);
            }

            //validasi kuantitas
            if(!$data['quantity'] || $data['quantity'] < 0 ){
                throw new \Exception($errors['invalid_quantity']);
            }

            //ambil produk dari database berdasarkan id_gas
            $product = ProductModel::findById($data['productId']);
            if(!$product){
                throw new \Exception($errors['product_not_found']);
            }

            //cek apakah quantity melebihi stok
            if(!$data['quantity'] > $product['Stok']){
                throw new \Exception($errors['quantity_exceeds_stock']);
            }

            // hitung biaya pengiriman
            $deliveryFee = $data['deliveryFee'] ? : 0;
            $perUnitDeliveryFee = 2000;
            $calculateDeliveryFee = $perUnitDeliveryFee * $data['quantity'];
            $totalDeliveryFee = ($deliveryFee > 0) ? $calculateDeliveryFee : 0;

            //Total harga = (harga produk * kuantitas) + biaya pengiriman
            $expectedTotalPrice = ($product['Harga_gas'] * $data['quantity']) + $totalDeliveryFee;

            //validasi total harga
            if(!$data['submittedTotalHarga'] || $data['submittedTotalHarga'] != $expectedTotalPrice){
                throw new \Exception($errors['invalid_total_price']);
            }

            //Jika semua validasi berhasil
            return [
                'status' => 'success'
            ];
        }catch(\Exception $e){
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function createOrder($data){
        try {
            $db = Database::getConnection();
            $db->begin_transaction();

            $stmt = $db->prepare("INSERT INTO " . self::$table . " (id_Order, user_id, id_gas, id_alamat, Qty, delivery_method, delivery_fee, totalharga, status)
                                  VALUES(?,?,?,?,?,?,?,?,?)");
    
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $db->error);
            }
    
            // Binding parameter
            $stmt->bind_param(
                'siiiisiis',
                $data['order_id'], 
                $data['id_user'], 
                $data['productId'], 
                $data['alamat'], 
                $data['quantity'], 
                $data['delivery_method'], 
                $data['deliveryFee'], 
                $data['submittedTotalHarga'], 
                $data['status']
            );
    
            // Eksekusi statement
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Failed to execute query: " . $stmt->error);
            }
            
            //kurangi stok gas setelah pesanan berhasil dibuat
            $stockUpdate = self::updateStock($data['productId'], $data['quantity']);
            if(!$stockUpdate){
                throw new \Exception("Failed to update stock for product ID: " . $data['productId']);
            }

            $db->commit();
            return true;
        } catch (\Exception $e) {
            // Log error dan lemparkan pesan ke controller
            $db->rollback();
            error_log($e->getMessage());
            throw new \Exception("Database Error: " . $e->getMessage());
        }
    }
    

    public static function updateStock($productId, $quantity){
        try{
            $db = Database::getConnection();
            $stmtUpdate = $db->prepare("UPDATE " . self::$tb_gas . " SET Stok = Stok - ? WHERE id_gas = ?");
            if(!$stmtUpdate){
                throw new \Exception("Failed to prepare statement" . $db->error);
            }

            $stmtUpdate->bind_param('ii', $quantity, $productId);
            $updateSuccess = $stmtUpdate->execute();
            if(!$updateSuccess){
                throw new \Exception("Failed to update stock" . $stmtUpdate->error);
            }
            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }


 public static function updateOrderStatus($order_id, $status){
    try{
        $db = Database::getConnection(); // Pastikan ini adalah metode yang benar
        $stmt = $db->prepare("UPDATE " . self::$table . " SET status = ? WHERE id_Order = ?");

        if(!$stmt){
            throw new \Exception("Failed to prepare statement: " . $db->error);
        }

        $stmt->bind_param("ss", $status, $order_id); // Perhatikan urutan parameter
        $success = $stmt->execute();

        if(!$success){
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        return true;
    }catch(\Exception $e){
        error_log($e->getMessage()); // Cek log untuk pesan error
        return false;
    }
}


    public static function getOrderByUID($userId){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("
                            SELECT ec_order.id_Order, ec_gas.Jenis_gas, ec_order.Qty, ec_order.totalharga
                            FROM " . self::$table . " 
                            JOIN ". self::$tb_gas ." ON ec_order.id_gas = ec_gas.id_gas
                            WHERE ec_order.user_id = ?
                     ");
            
            if(!$stmt){
                throw new \Exception("Failed to prepare statement: " . $db->error);
            }

            $stmt->bind_param("i", $userId);
            $success = $stmt->execute();
            if(!$success){
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }
            return true;

        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }


    

}