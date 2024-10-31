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
                throw new \Exception('Invalid request method', 405);
            }
            $this->checkRequest();

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

    public function getUlasan(){
        try{
            $endpoint = "/";
            $this->checkReferer($endpoint);
            $this->checkRequest();

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