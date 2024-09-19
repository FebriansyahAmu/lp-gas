<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\AdminController;
use App\Controllers\AccountController;
use App\Controllers\CheckoutController;


use App\Middleware\AuthMiddleWare;

use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/about', HomeController::class, 'about');

$router->get('/login', AuthController::class, 'login');
$router->get('/register', AuthController::class, 'register');
$router->get('/checkauth', AuthController::class, 'checkAuthStatus'); 

//auth routes
$router->post('/auth/register', AuthController::class, 'registerAct');
$router->post('/auth/login', AuthController::class, 'loginAct');

//product
$router->get('/product/{id}', ProductController::class, 'product');
$router->get('/api/product/{id}', ProductController::class, 'getProduct');
$router->get('/api/products', ProductController::class, 'getAllProduct');

//account
$router->get('/account', AccountController::class, 'index', [
    'class' => AuthMiddleware:: class,
    'role' => 'user'
]);

$router->get('/riwayat-pembelian', AccountController::class, 'getRiwayatPembelian', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

//router untuk handle alamat
$router->get('/account/alamat', AccountController::class, 'indexAlamat', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->post('/Alamat/Create', AccountController::class, 'Alamat', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);
$router->get('/Alamat', AccountController::class, 'getAlamatbyUser', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->get('/Alamat/{id}', AccountController::class, 'getAlamatbyID', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->put('/Alamat/Edit', AccountController::class, 'editAlamat', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->delete('/Alamat/Delete/{id}', AccountController::class, 'deleteAlamat', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);


//chechkouts
$router->post('/checkout', CheckoutController::class, 'checkout', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->post('/payment-notif', CheckoutController::class, 'handleNotification');

//admin routes
$router->get('/dashboard', AdminController::class, 'dashboard', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);



$router->get('/logout', AuthController::class, 'logoutUsers');

$router->dispatch();