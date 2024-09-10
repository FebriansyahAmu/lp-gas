<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\AdminController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/about', HomeController::class, 'about');

$router->get('/login', AuthController::class, 'login');
$router->get('/register', AuthController::class, 'register');

//auth routes
$router->post('/auth/register', AuthController::class, 'registerAct');
$router->post('/auth/login', AuthController::class, 'loginAct');

//product
$router->get('/product/{id}', ProductController::class, 'product');
$router->get('/api/product/{id}', ProductController::class, 'getProduct');


$router->get('/dashboard', AdminController::class, 'dashboard', [
    'class' => \App\Middleware\AuthMiddleware::class,
    'role' => 'admin'
]);



$router->dispatch();