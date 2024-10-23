<?php
namespace App\Controllers;

use App\Controller;
use App\Models\Ulasan;
use App\Middleware\AuthMiddleWare;

class UlasanController extends Controller
{
    public function kirimUlasan(){
        try{
            $allowedOrigin = "https://pangkalangasabdulrahman.online";
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                if ($_SERVER['HTTP_ORIGIN'] === $allowedOrigin) {
                    header("Access-Control-Allow-Origin: $allowedOrigin");
                    header("Access-Control-Allow-Methods: POST");
                    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
                } else {
                    http_response_code(403);
                    echo json_encode([
                        'error' => 'Origin not allowed'
                    ]);
                    exit();
                }
            }

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

    public function getUlasan(){
        try{
            $allowedOrigin = "https://pangkalangasabdulrahman.online";
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                if ($_SERVER['HTTP_ORIGIN'] === $allowedOrigin) {
                    header("Access-Control-Allow-Origin: $allowedOrigin");
                    header("Access-Control-Allow-Methods: GET");
                    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
                } else {
                    header('Location: /');
                    exit();
                }
            }
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