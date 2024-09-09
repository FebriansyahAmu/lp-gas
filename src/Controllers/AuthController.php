<?php

namespace App\Controllers;
use App\Controller;
use App\Models\User;

use App\Helpers\JwtHelper;



class AuthController extends Controller
{
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
                    'namalengkap' => filter_input(INPUT_POST, 'namalengkap', FILTER_SANITIZE_STRING),
                    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                    'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING),
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
                throw new Exception('Method not allowd', 405);
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
                'nohp' => $user['No_Hp'],
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

             echo json_encode([
                'status' => 'success',
                'token' => $token
             ]);

        }catch(\Exception $e){
            http_response_code($e->getCode() ? $e->getCode() : 400);

            echo json_encode([
                'status' => 'error',
                'message'=> $e->getMessage()
            ]);
        }
    }
}
