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

    public static function checkStok($id){
        $product = self::findById($id);
        if($product && $product['Stok'] > 0){
            return true;
        }
        return false;
    }


    public static function inputGas($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (Jenis_gas, Harga_gas, Stok, foto_gas) VALUES(?,?,?,?)");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('siis', $data['jenisGas'], $data['hargaGas'], $data['stok'], $data['gambarGas']);
            $success = $stmt->execute();

            if(!$success){
                throw new \Exception("Failed to execute query: ", $stmt->error);
            }

            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
    
    public static function updateDataGas($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE " . self::$table . " SET Jenis_gas = ?, Harga_gas = ?, Stok = ?, foto_gas = ? WHERE id_gas = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('siisi', $data['jenisGas'], $data['hargaGas'], $data['stok'], $data['gambarGas'], $data['idGas']);
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

    public static function deleteDataGas($id){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT foto_gas FROM " . self::$table . " WHERE id_gas = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare select statement", $db->error);
            }
    
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
    
            if(!$product){
                throw new \Exception("Data Gas tidak ditemukan", 404);
            }
    
            $foto_filepath = $product['foto_gas'];
            if($foto_filepath && file_exists($foto_filepath)){
                unlink($foto_filepath); 
            }

            $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id_gas = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare delete statement", $db->error);
            }
    
            $stmt->bind_param('i', $id);
            $success = $stmt->execute();
    
            if(!$success){
                throw new \Exception("Failed to execute delete query", $stmt->error);
            }
    
            return true;
    
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
