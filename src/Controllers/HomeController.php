<?php

namespace App\Controllers;
use App\Controller;
use App\Middleware\AuthMiddleware;

class HomeController extends Controller
{
    protected $authMiddleware;

    public function __construct(){
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
    }
    public function index()
    {
        $isLoggedIn = $this->authMiddleware->handle();
        $this->render('/Home/index', ['isLoggedIn' => $isLoggedIn] );
    }

    public function pageNotFound(){
        $data = [];
        $this->render('/404/index', $data, null);
    }

}