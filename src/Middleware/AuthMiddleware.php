<?php

namespace App\Middleware;

use App\Helpers\JwtHelper;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class AuthMiddleware {
    
    public static function checkAuth($role = null) {
        try {
            // Periksa apakah cookie `authToken` ada
            if (!isset($_COOKIE['authToken'])) {
                http_response_code(401);
                header('Location: /login');
                exit;
            }

            // Ambil token dari cookie
            $token = $_COOKIE['authToken'];
            $userData = JwtHelper::validateToken($token);

            if (!$userData) {
                http_response_code(401);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid token',
                ]);
                exit;
            }

            // Periksa role jika diperlukan
            if ($role && (!isset($userData['role']) || $userData['role'] !== $role)) {
                http_response_code(403);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Access forbidden: insufficient role',
                ]);
                exit;
            }

            // Token valid dan role sesuai jika ada
            return $userData;
        } catch (ExpiredException $e) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Token has expired',
            ]);
            exit;
        } catch (SignatureInvalidException $e) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid token signature',
            ]);
            exit;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
            exit;
        }
    }

    public function handle(){
        $isLoggedIn = false;
        if(isset($_COOKIE['authToken'])){
            try{
                $token = $_COOKIE['authToken'];
                $userData = JwtHelper::validateToken('$token');
                if($userData){
                    $isLoggedIn = true;
                }
            }catch(\Exception $e){
                error_log($e->getMessage());
            }
        }

        return $isLoggedIn;
    }
}
