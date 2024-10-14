<?php

namespace App\Controllers;
use App\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Alamat;
use App\Models\Order;
use App\Models\User;

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

    public function indexAlamat(){
        $isLoggedIn = $this->authMiddleware->handle();
        $this->render('/Alamat/index', ['isLoggedIn' => $isLoggedIn] );
    }


    public function indexPengaturan(){
        $isLoggedIn = $this->authMiddleware->handle();
        $this->render('/Pengaturan/index', ['isLoggedIn' => $isLoggedIn]);
    }


    public function Alamat(){
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception("Method not allowed", 405);
            }

            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $input = file_get_contents("php://input");
            $putVars = json_decode($input, true);
            
            $data = [
                'userId' => $userId,
                'Detail_alamat' => filter_var($putVars['Detail_alamat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'Description' => filter_var($putVars['Description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];
            

            if(Alamat::createAlamat($data)){
                header('Content-Type: application/json');
                http_response_code(201);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Alamat berhasil dibuat'
                ]);
            }else{
                throw new \Exception("Gagal membuat alamat");
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


    public function editAlamat(){
        try{
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $input = file_get_contents("php://input");
            $putVars = json_decode($input, true); // decode data JSON

            // Pastikan ada validasi sebelum mengakses variabel
            $data = [
                'iduser' => $userId,
                'idAlamat' => isset($putVars['id_Alamat']) ? filter_var($putVars['id_Alamat'], FILTER_SANITIZE_NUMBER_INT) : null,
                'Detail_alamat' => isset($putVars['Detail_alamat']) ? filter_var($putVars['Detail_alamat'], FILTER_SANITIZE_SPECIAL_CHARS) : null,
                'Description' => isset($putVars['Description']) ? filter_var($putVars['Description'], FILTER_SANITIZE_SPECIAL_CHARS) : null
            ];
        
            $putAlamat = Alamat::putAlamatByUID($data);
            if($putAlamat){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Alamat berhasil diubah'
                ]);
            }else{
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Alamat tidak ditemukan'
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


    public function getAlamatbyID($id){
        try{
            // $this->checkRefer();
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $getAlamat = Alamat::getAlamatUID($id, $userId);
            if($getAlamat){
                echo json_encode([
                    'data' => $getAlamat
                ]);
            }else{
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                   'message' => 'Alamat tidak ditemukan'
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

    public function deleteAlamat($id){
        try{
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $deleteAlamat = Alamat::deleteAlamatByUID($id, $userId);
            if($deleteAlamat){
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Alamat berhasil dihapus'
                ]);
            }else{
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                   'message' => 'Alamat tidak ditemukan'
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


    //Riwayat Pembelian
    public function getRiwayatPembelian(){
        try{

            // $this->checkRefer();
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $riwayatPembelian = Order::getOrderByUID($userId);
            if($riwayatPembelian){
                echo json_encode([
                    'data' => $riwayatPembelian
                ]);
            }else{
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                   'message' => 'Riwayat pembelian tidak ditemukan'
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

    //ini untun pengaturan akun
    public function getUserbyuid(){
        try{
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $getUser = User::getUserByUID($userId);
            if(!$getUser){
                throw new \Exception('User not found', 404);
            }
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $getUser
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

    public function updateProfile(){
        try{
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];

            $oldData = User::getUserByUID($userId);
            if(!$oldData){
                throw new \Exception('User not found', 404);
            }

            $data = [
                'userId' => $userId,
                'namaLengkap' => filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'noHp' => filter_input(INPUT_POST, 'no_hp', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            if(isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK){
                $targetDir = 'img/pf';
                $fileName = basename($_FILES['profilePicture']['name']);
                $targetFile = $targetDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            
                $allowedFileType = ['jpg', 'jpeg', 'png'];
                if(!in_array($imageFileType, $allowedFileType)){
                    throw new \Exception('Format file tidak didukung', 400);
                }

                if(move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)){
                    if(file_exists($oldData['foto_filepath'])){
                        unlink($oldData['foto_filepath']);
                    }
                    $data['profilePicture'] = $targetFile;
                }else{
                    throw new \Exception('Gagal mengunggah gambar', 500);
                }
            }else{
                $data['profilePicture'] = $oldData['foto_filepath'];
            }

            $updateData = User::updateUserData($data);
            if(!$updateData){
                throw new \Exception('Gagal memperbarui data', 500);
            }

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui'
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

    private function checkRefer(){
        $allowedReferer = "http://localhost:3000";
        if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) === false) {
           header('Location: /');
           exit;
        }
    }

}