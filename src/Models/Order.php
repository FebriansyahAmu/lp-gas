<?php

namespace App\Models;

use App\Models\ProductModel;
use App\Core\Database;

Class Order{
    protected static $table = 'ec_order';
    protected static $table_gas = 'ec_gas';
    protected static $tb_user = 'ec_user';
 
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


    public static function validationCartCO($data){
        $errors = [
            'invalid_product_id' => 'Id gas tidak valid',
            'invalid_quantity' => 'Kuantitas harus lebih dari 0 dan valid',
            'product_not_found' => 'Product tidak ditemukan',
            'quantity_exceeds_stock' => 'Kuantitas melebihi stok yang tersisa',
            'invalid_total_price' => 'Total harga tidak sesuai'
        ];
    
        try {
            // Validasi productId
            if (!$data['productId'] || !is_int($data['productId'])) {
                throw new \Exception($errors['invalid_product_id']);
            }
    
            // Validasi quantity
            if (!$data['quantity'] || $data['quantity'] <= 0) {
                throw new \Exception($errors['invalid_quantity']);
            }
    
            // Ambil produk dari database
            $product = ProductModel::findById($data['productId']);
            if (!$product) {
                throw new \Exception($errors['product_not_found']);
            }
    
            // Cek stok
            if ($data['quantity'] > $product['Stok']) {
                throw new \Exception($errors['quantity_exceeds_stock']);
            }
    
            // Validasi total harga per produk
            $expectedTotalPrice = $product['Harga_gas'] * $data['quantity'];
            if ($data['submittedTotalHarga'] != $expectedTotalPrice) {
                throw new \Exception($errors['invalid_total_price']);
            }
    
            return ['status' => 'success'];
    
        } catch (\Exception $e) {
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
            if ($data['alamat'] === NULL) {
                // Definisikan variabel null untuk bind_param
                $nullValue = NULL;
                
                $stmt->bind_param(
                    'siiiisiis',
                    $data['order_id'], 
                    $data['id_user'], 
                    $data['productId'], 
                    $nullValue,  // Gunakan variabel null
                    $data['quantity'], 
                    $data['delivery_method'], 
                    $data['deliveryFee'], 
                    $data['submittedTotalHarga'], 
                    $data['status']
                );
            } else {
                // Jika ada alamat, bind dengan nilai yang diberikan
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
            }
            
            
    
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
            $stmtUpdate = $db->prepare("UPDATE " . self::$table_gas . " SET Stok = Stok - ? WHERE id_gas = ?");
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


    // public static function deleteExpiredPayment(){
    //     try{
    //         $db = Database::getConnection();
    //         $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE status = ? AND Interval ....");
    //     }catch(\Exception $e){
    //         error_log($e->getMessage());
    //         return false;
    //     }
    // }


    public static function deleteExpireOrder($orderId){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id_Order = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param("s", $orderId);
            $success = $stmt->execute();
            if(!$success){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return true;
        }catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getOrderByUID($userId){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("
                           SELECT id_Order, SUM(Qty) AS total_qty, SUM(totalharga) + delivery_fee AS total_harga, status, snap_token
                           FROM ". self::$table ."
                           GROUP BY id_Order
                           ORDER BY created_at DESC
                     ");
            
            if(!$stmt){
                throw new \Exception("Failed to prepare statement: " . $db->error);
            }
            $stmt->execute();

            $result = $stmt->get_result();
            if(!$result){
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);

        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }


    public static function getRiwayatOrders(){
        try{
            $db = Database::getConnection();

            $userRole = 'user';
            $stmt = $db->prepare("
                    SELECT
                        ec_order.id_Order,
                        ec_user.Nama_lengkap,
                        ec_order.Qty,
                        ec_order.delivery_method,
                        ec_order.delivery_fee,
                        ec_order.totalharga,
                        ec_order.status
                    FROM
                        " . self::$table ."
                    JOIN ". self::$table_gas ." 
                        ON ec_order.id_gas = ec_gas.id_gas
                    JOIN ". self::$tb_user ." 
                        ON ec_order.user_id = ec_user.user_id
                    WHERE
                        ec_user.role = ?
                    GROUP BY
                        ec_order.id_Order
                    ORDER BY
                        ec_order.created_at DESC
            ");

            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('s', $userRole);
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
    
    public static function updateSnapToken($orderId, $snapToken = NULL){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE " . self::$table . " SET snap_token = ? WHERE id_Order = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('ss', $snapToken, $orderId);
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