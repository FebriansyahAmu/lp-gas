<?php

namespace App\Controllers;
use App\Controller;
use App\Middleware\AuthMiddleware;

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

}