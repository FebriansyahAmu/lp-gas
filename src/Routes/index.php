<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\AdminController;
use App\Controllers\AccountController;
use App\Controllers\CheckoutController;
use App\Controllers\CartController;
use App\Controllers\UlasanController;


use App\Middleware\AuthMiddleware;

use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/404', HomeController::class, 'pageNotFound');


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

$router->post('/Alamat/pilih-alamat/{id}', AccountController::class, 'pilihAlamatbyUID', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);


//index cart
$router->get('/account/cart', CartController::class, 'indexCart', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

//add to carts
$router->post('/api/add-cart', CartController::class, 'addCart', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->get('/api/cart-alamat', CartController::class, 'getAlamatCart', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

//getall carts
$router->get('/api/carts', CartController::class, 'getAllCartByUID',[
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->delete('/api/carts/{id}', CartController::class, 'deleteCartByID', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

//chechkouts
$router->post('/checkout', CheckoutController::class, 'checkout', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->post('/checkout-carts', CheckoutController::class, 'checkoutCart', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->post('/payment-notif', CheckoutController::class, 'handleNotification');



//admin routes
$router->get('/dashboard', AdminController::class, 'dashboard', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);


//CRUD DATA GAS
$router->get('/data-gas', AdminController::class, 'indexGas', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);


$router->post('/gas/create', ProductController::class, 'inputDataGas', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);

$router->post('/gas/edit', ProductController::class, 'editDataGas', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);

$router->delete('/gas/delete/{id}', ProductController::class, 'deleteDataGas', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);


//GET DATA USERS
$router->get('/data-customer', AdminController::class, 'indexDataCustomer', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);

$router->get('/data/customers', AdminController::class, 'getDataCustomer', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);

$router->get('/data/total-customer', AdminController::class, 'getCountUsers', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);


//GET DATA PEMBELIAN
$router->get('/data/riwayat-pembelian', AdminController::class, 'getRiwayatPembelian', [
    'class' => AuthMiddleware::class,
    'role' => 'admin'
]);


//ulasan
$router->post('/ulasan', UlasanController::class, 'kirimUlasan',[
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->get('/data/ulasan', UlasanController::class, 'getUlasan');



//pengaturan akun
$router->get('/account/pengaturan', AccountController::class, 'indexPengaturan', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->get('/account/user-data', AccountController::class, 'getUserbyuid', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->post('/account/update-profile', AccountController::class, 'updateProfile', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);

$router->post('/account/ubah-password', AccountController::class, 'ubahPassword', [
    'class' => AuthMiddleware::class,
    'role' => 'user'
]);


//Verifikasi akun
$router->get('/verifikasi-email/{token}', AuthController::class, 'emailVerification');
$router->get('/verifikasi-sukses', AuthController::class, 'verificationSuccess');
$router->post('/auth/resend-verification', AuthController::class, 'resendLink');


//Lupa Password
$router->get('/lupa-password', AuthController::class, 'lupaPassword');
$router->post('/auth/password-reset', AuthController::class, 'forgetPassword');
$router->get('/auth/password-reset/{token}', AuthController::class, 'resetPassword');
$router->post('/auth/new-password', AuthController::class, 'newPassword');

//logout
$router->get('/logout', AuthController::class, 'logoutUsers');

$router->dispatch();