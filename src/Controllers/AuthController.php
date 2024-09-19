<?php

namespace App\Controllers;
use App\Controller;
use App\Models\User;

use App\Helpers\JwtHelper;
use App\Middleware\AuthMiddleware;



class AuthController extends Controller
{

    protected $authMiddleware;

    public function __construct(){
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
    }

    public function login()
    {
        $data = []; 
        $this->render('/Login/index', $data, null); 
    }

    public function register(){
        $data = [];
        $this->render('/Register/index', $data, null);
    }

    public function registerAct(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try{
                $data = [
                    'namalengkap' => filter_input(INPUT_POST, 'namalengkap', FILTER_SANITIZE_SPECIAL_CHARS),
                    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                    'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS),
                    'password' => filter_input(INPUT_POST, 'password', FILTER_DEFAULT),
                ];

                $errors = User::validateData($data);
                if(!empty($errors)){
                    echo json_encode([
                        'status' => 'error',
                        'message' => $errors
                    ]);
                    return;
                }
                
                if(User::findByEmail($data['email'])){
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Email sudah terdaftar'
                    ]);
                    return;
                }

                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                $data['isverified'] = 0;
                $data['role'] = 'user';

                if(User::create($data)){
                    http_response_code(201);
                    echo json_encode([
                       'status' =>'success',
                        'message' => 'Register berhasil, silahkan cek email anda untuk verifikasi'
                    ]);
                }else{
                    throw new \Exception('Gagal membuat akun');
                }
            }catch(\Exception $e){
                error_log($e->getMessage());

                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        }else{
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function loginAct(){
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new Exception('Method not allowed', 405);
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
        
            if(!$email || !$password){
                throw new \Exception("Email or password cannot be empty", 400);
            }
            
            $user = User::verifyUser($email, $password);
            if(!$user){
                throw new \Exception("Invalid credentials", 401);
            }

             $data = [
                'id' => $user['user_id'],
                'namalengkap' => $user['Nama_lengkap'],
                'role' => $user['role']
             ];

             $token = JwtHelper::generateToken($data);

             setcookie('authToken', $token, [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
             ]);
            if($user['role'] === 'admin'){
                echo json_encode([
                    'status' => 'success',
                    'redirect' => '/dashboard'
                ]);
                exit();
             }else if($user['role'] === 'user'){
                echo json_encode([
                    'status' => 'success',
                    'redirect' => '/account'
                ]);
             }


        }catch(\Exception $e){
            http_response_code($e->getCode() ? $e->getCode() : 400);

            echo json_encode([
                'status' => 'error',
                'message'=> $e->getMessage()
            ]);
        }
    }

    public function checkAuthStatus(){
        try{
            $this->checkRefer();
            $auth =  $this->authMiddleware->handle();
            if($auth){
                echo json_encode([
                    "auth" => true
                ]);
            }else{
                http_response_code(401);
                echo json_encode([
                    "auth" => false
                ]);
            }
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function logoutUsers(){
        setcookie('authToken', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        header('Location: /login');
        exit();
    }

    private function checkRefer(){
        $allowedReferer = "http://localhost:3000";
        if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) === false) {
           header('Location: /');
           exit;
        }
    }
}
