<?php

namespace App\Controllers;
use App\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\CartModel;
use App\Models\Alamat;




class CartController extends Controller{

    protected $authMiddleware;

    public function __construct(){
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
    }

    public function indexCart(){
        $isLoggedIn = $this->authMiddleware->handle();
        $this->render('/Cart/index', ['isLoggedIn' => $isLoggedIn] );
    }

    public function addCart(){
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method', 405);
            }
    
            // Ambil JSON payload dari request body
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true); // decode JSON jadi array asosiatif
    
            // Validasi autentikasi user
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];
    
            // Ambil data dari JSON
            $id_gas = filter_var($data['id_gas'], FILTER_VALIDATE_INT);
            $jenis_gas = filter_var($data['jenis_gas'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $harga_gas = str_replace(',', '', $data['harga_gas']);
            $harga_gas = filter_var($harga_gas, FILTER_VALIDATE_INT);
            $qty = filter_var($data['qty'], FILTER_VALIDATE_INT);
    
            if (!$id_gas || !$harga_gas || !$qty) {
                throw new \Exception('Data yang dikirim tidak valid', 400);
            }
    
            // Siapkan data untuk ditambahkan ke keranjang
            $cartData = [
                'user_id' => $userId,
                'id_gas' => $id_gas,
                'jenis_gas' => $jenis_gas,
                'harga_gas' => $harga_gas,
                'qty' => $qty
            ];
    
            // Tambahkan ke keranjang menggunakan model
            $addToCart = CartModel::addToCart($cartData);
    
            if ($addToCart) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Gas elpiji berhasil ditambahkan ke keranjang'
                ]);
            } else {
                throw new \Exception('Terjadi kesalahan, silakan coba lagi nanti', 500);
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



    public function getAllCartByUID(){
        try{
            $allowedOrigin = "https://pangkalangasabdulrahman.online";
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                if ($_SERVER['HTTP_ORIGIN'] === $allowedOrigin) {
                    header("Access-Control-Allow-Origin: $allowedOrigin");
                    header("Access-Control-Allow-Methods: GET");
                    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
                } else {
                    header('Location: /account/cart');
                    exit();
                }
            }
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $getAllchart = CartModel::getallCartUID($userId);
            if($getAllchart){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $getAllchart
                ]);
            }else{
                throw new \Exception('Data not found', 404);
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

    public function deleteCartByID($id){
        try{
            $allowedOrigin = "https://pangkalangasabdulrahman.online";
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                if ($_SERVER['HTTP_ORIGIN'] === $allowedOrigin) {
                    header("Access-Control-Allow-Origin: $allowedOrigin");
                    header("Access-Control-Allow-Methods: DELETE");
                    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
                } else {
                    http_response_code(403);
                    echo json_encode([
                        'error'=> 'Origin not allowed'
                    ]);
                    exit();
                }
            }

            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $deleteCart = CartModel::deleteCartByID($id, $userId);
            if($deleteCart){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cart item berhasil dihapus'
                ]);
            }else{
                throw new \Exception('Data not found', 404);
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
    

    public function getAlamatCart(){
        try{
            $allowedOrigin = "https://pangkalangasabdulrahman.online";
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                if ($_SERVER['HTTP_ORIGIN'] === $allowedOrigin) {
                    header("Access-Control-Allow-Origin: $allowedOrigin");
                    header("Access-Control-Allow-Methods: GET");
                    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
                } else {
                    header('Location: /account/cart');
                    exit();
                }
            }
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $alamatCart = Alamat::getAlamatCart($userId);
            if($alamatCart){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $alamatCart
                ]);
            }else{
                throw new \Exception('Alamat tidak ditemukan', 404);
            }
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }

    private function checkReferer($endpoint){
        $allowedReferer = "https://pangkalangasabdulrahman.online";
        if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) !== 0) {
            header("Location: $endpoint");
            exit();
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