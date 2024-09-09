<?php

namespace App\Middleware;

use App\Helpers\JwtHelper;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class AuthMiddleware {
    public static function checkAuth() {
        try {
            $headers = getallheaders();
            if (!isset($headers['Authorization'])) {
                throw new \Exception("Access denied");
                //returnkan 404 not found nanti yah
            }

            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $userData = JwtHelper::validateToken($token);

            if ($userData) {
                return $userData;
            }

            throw new \Exception("Invalid token");
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
                'message' => 'Invalid token signature'
            ]);
            exit;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }
}
