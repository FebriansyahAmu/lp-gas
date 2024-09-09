<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper{
    private static $secretKey;

    public static function init(){
        self::$secretKey = getenv('JWT_SECRET');
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

        try{
            return JWT::encode($payload, self::$secretKey, 'HS256');
        }catch(\Exception $e){
            error_log("JWT Encoding error:" . $e->getMessage());
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