<?php
namespace App\Controllers;

use App\Controller;
use App\Models\ProductModel;
use App\Middleware\AuthMiddleware;

class ProductController extends Controller
{
    protected $authMiddleware;

    public function __construct(){
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
    }
    public function product($id)
    {
        $isLoggedIn = $this->authMiddleware->handle();
        try{
            $product = ProductModel::findbyId($id);

            if($product){
                $this->render('/Product/index', [
                    'product' => $product,
                    'isLoggedIn' => $isLoggedIn
                ]);
            }else{
                throw new \Exception("Product tidak ditemukan", 404);
            }
        }catch(\Exception $e){
            $this->render('/Product/error', [
                'error' => $e->getMessage(),
                'isLoggedIn' => $isLoggedIn
            ]);
        }
    }

    public function getProduct($id){
        try{
            $this->checkRequest();
            $allowedReferer = "https://pangkalangasabdulrahman.online";
            if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) !== 0) {
                header('Location: /');
                exit();
            }
            $product = ProductModel::findbyId($id);

            if($product){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $product
                ]);
            }else{
                throw new \Exception("Product tidak ditemukan", 404);
            }
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getAllProduct() {
        try {
            $this->checkRequest();
            $allowedReferer = "https://pangkalangasabdulrahman.online";
            if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) !== 0) {
                header('Location: /');
                exit();
            }

            $product = ProductModel::getAll();
    
            if ($product) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $product
                ]);
            } else {
                throw new \Exception("Product tidak ditemukan", 404);
            }
    
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function inputDataGas(){
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception('Invalid request method', 405);
            }
            $data = [
                'jenisGas' => filter_input(INPUT_POST, 'jenisGas', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'hargaGas' => filter_input(INPUT_POST, 'hargaGas', FILTER_VALIDATE_INT),
                'stok' => filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT)
            ];

            if(isset($_FILES['gambarGas']) && $_FILES['gambarGas']['error'] === UPLOAD_ERR_OK){
                $targetDir = 'img/';
                $filenName = basename($_FILES['gambarGas']['name']);
                $targetFile = $targetDir . $filenName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


                $allowedFileType = ['jpg', 'jpeg', 'png', 'gif'];
                if(!in_array($imageFileType, $allowedFileType)){
                    throw new \Exception("Format gambar salah", 400);
                };

                if(!move_uploaded_file($_FILES['gambarGas']['tmp_name'], $targetFile)){
                    throw new \Exception("Gagal mengunggah gambar", 500);
                };
                
                $data['gambarGas'] = $targetFile;
            }else{
                throw new \Exception("Gambar gas wajib diunggah", 400);
            }
            

            $insertData = ProductModel::inputGas($data);
            if(!$insertData){
                throw new \Exception("Gagal menyimpan data", 500);
            }
            
            header('Content-Type: application/json');
            echo json_encode([
               'status' =>'success',
                'message' => 'Data gas berhasil disimpan'
            ]);
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
               'message' => $e->getMessage()
            ]);
        }
    }


    public function editDataGas() {
        try {
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception('Invalid request method', 405);
            }
            
            $id = filter_input(INPUT_POST, 'idGas', FILTER_VALIDATE_INT);
            $oldData = ProductModel::findbyId($id);
            if (!$oldData) {
                throw new \Exception("Data gas tidak ditemukan", 404);
            }
    
            $data = [
                'idGas' => $id,
                'jenisGas' => filter_input(INPUT_POST, 'jenisGas', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'hargaGas' => filter_input(INPUT_POST, 'hargaGas', FILTER_VALIDATE_INT),
                'stok' => filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT)
            ];
    
            // Logika upload gambar baru
            if (isset($_FILES['gambarGas']) && $_FILES['gambarGas']['error'] === UPLOAD_ERR_OK) {
                $targetDir = 'img/';
                $fileName = basename($_FILES['gambarGas']['name']);
                $targetFile = $targetDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
                $allowedFileType = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageFileType, $allowedFileType)) {
                    throw new \Exception('Invalid image file type', 400);
                }
    
                // Pindahkan file baru ke target directory
                if (move_uploaded_file($_FILES['gambarGas']['tmp_name'], $targetFile)) {
                    // Jika gambar baru berhasil diunggah, hapus gambar lama
                    if (file_exists($oldData['foto_gas'])) {
                        unlink($oldData['foto_gas']); // Hapus gambar lama
                    }
                    $data['gambarGas'] = $targetFile;
                } else {
                    throw new \Exception("Gagal mengunggah gambar", 500);
                }
            } else {
                $data['gambarGas'] = $oldData['foto_gas'];
            }
    
            $updateData = ProductModel::updateDataGas($data);
            if (!$updateData) {
                throw new \Exception("Gagal memperbarui data", 500);
            }
    
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil diupdate'
            ]);
    
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    

    public function deleteDataGas($id){
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
                throw new \Exception('Invalid request method', 405);
            }

            $deleteDataGas = ProductModel::deleteDataGas($id);
            if($deleteDataGas){
                header('Content-Type: application/json');
                echo json_encode([
                    'status'=> 'success',
                    'message' => 'Data gas berhasil dihapus'
                ]);
            }else{
                throw new \Exception("Data Gas tidak ditemukan", 404);
            }

        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    private function checkRequest(){
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            http_response_code(403); 
            echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak diizinkan']);
            exit();
        }
    }
}
