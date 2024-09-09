<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class JwtHelper{
    private static $secretKey;

    public static function init(){
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        self::$secretKey = $_ENV['JWT_SECRET'];
    }

    public static function generateToken($data){
         self::init();
        $payload = [
            'iss' => 'localhost', //Issuer optional
            'aud' => 'localhost', //Audience optional
            'iat' => time(),   //Issued at
            'exp' => time() + 3600, //Expires at 1 hour
            'data' => $data
        ];

        try {
            $token = JWT::encode($payload, self::$secretKey, 'HS256');
            if (!$token) {
                error_log("Failed to encode token");
            }
            return $token; 
        } catch (\Exception $e) {
            error_log("JWT Encoding error: " . $e->getMessage());
            return false;
        }
    }

    public static function validateToken($token){
        self::init();
        try{
            $decoded = JWT::decode($token, new Key(self::$secretKey, 'HS256'));
            return (array) $decoded->data;
        }catch(\Firebase\JWT\ExpiredException $e){
            return ['error' => 'Token has expired'];
        }catch(\Firebase\JWT\SignatureInvalidException $e){
            return ['error' => 'Invalid token signature'];
        }catch(\Exception $e){
            return ['error' => 'Invalid token'];
        }
    }
}