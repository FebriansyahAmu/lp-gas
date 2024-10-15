<?php
namespace App\Controllers;

use App\Controller;
use App\Models\Ulasan;
use App\Middleware\AuthMiddleWare;

class UlasanController extends Controller
{
    public function kirimUlasan(){
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception('Invalid request method', 400);
            }

            $userData = AuthMiddleWare::checkAuth();
            $userId = $userData['id'];

            $data = [
                'userId' => $userId,
                'ulasan' => filter_input(INPUT_POST, 'ulasan', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'rating' => filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT)
            ];

            $kirimUlasan = Ulasan::createUlasan($data);
            if(!$kirimUlasan){
                throw new \Exception('Terjadi kesalahan silahkan coba lagi nanti', 500);
            }

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Ulasan berhasil dikirim'
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

    public function getDataUlasan(){
        try{
            $dataUlasan = Ulasan::getdataUlasan();
            if(!$dataUlasan){
                throw new \Exception('Data tidak ditemukan', 404);
            }
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $dataUlasan
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

    public function getUlasan(){
        try{
            $ulasan = Ulasan::getDataUlasan();
            if(!$ulasan){
                throw new \Exception("Tidak ada ulasan", 404);
            }
            header('Content-Type: application/json');
            echo json_encode([
                'data' => $ulasan
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
}