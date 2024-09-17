<?php

namespace App\Controllers;
use App\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Alamat;

class AccountController extends Controller
{
    protected $authMiddleware;

    public function __construct(){
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
    }
    public function index()
    {
        $isLoggedIn = $this->authMiddleware->handle();
        $this->render('/Account/index', ['isLoggedIn' => $isLoggedIn] );
    }

    public function Alamat(){
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception("Method not allowed", 405);
            }

            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $data = [
                'userId' => $userId,
                'Detail_alamat' =>  filter_input(INPUT_POST, "Detail_alamat", FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'Description' => filter_input(INPUT_POST, "Description", FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            if(Alamat::createAlamat($data)){
                http_response_code(201);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Alamat berhasil dibuat'
                ]);
            }else{
                throw new Exception("Gagal membuat alamat");
            }

        }catch(\Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getAlamatbyUser(){
        try{

            // $this->checkRefer();

            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $alamat = Alamat::getAlamatByUsersId($userId);
            if($alamat){
                echo json_encode([
                    'data' => $alamat
                ]);
            }else{
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Alamat tidak ditemukan untuk pengguna ini'
                ]);
            }
            
        }catch(\Exception $e){
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    private function checkRefer(){
        $allowedReferer = "http://localhost:3000";
        if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) === false) {
           header('Location: /');
           exit;
        }
    }

}