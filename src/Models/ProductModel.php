<?php

namespace App\Models;

use App\Core\Database;

class ProductModel {
    protected static $table = 'ec_gas';
    
 
    public static function findbyId($id){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id_gas= ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to execute query: ", $stmt->error);
            }

            return $result->fetch_assoc();
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getAll(){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM " . self::$table);
            
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

//     public function getProduct($id){
//     try {
//         // Cek apakah permintaan adalah AJAX atau API request
//         if (stripos($_SERVER['HTTP_ACCEPT'], 'application/json') === false || 
//             stripos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
//             throw new \Exception("Invalid request", 403);
//         }

//         $product = ProductModel::findById($id);

//         if ($product) {
//             header('Content-Type: application/json');
//             echo json_encode($product);
//         } else {
//             http_response_code(404);
//             echo json_encode(["status" => "error", "message" => "Product not found"]);
//         }
//     } catch (\Exception $e) {
//         http_response_code(403);
//         echo json_encode(["status" => "error", "message" => $e->getMessage()]);
//     }
// }

}
