<?php

namespace App\Controllers;
use App\Controller;
use App\Middleware\AuthMiddleware;

class HomeController extends Controller
{
    public function index()
    {
        $isLoggedIn = false;
        if (isset($_COOKIE['authToken'])) {
            try {
                $token = $_COOKIE['authToken'];
                $userData = \App\Helpers\JwtHelper::validateToken($token);
                if ($userData) {
                    $isLoggedIn = true;
                }
            } catch (\Exception $e) {
                $isLoggedIn = false;
            }
        }

        $this->render('/Home/index', ['isLoggedIn' => $isLoggedIn] );
    }

}