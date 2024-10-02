<?php

namespace App\Controllers;
use App\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\CartModel;




class CartController extends Controller{

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
    
}