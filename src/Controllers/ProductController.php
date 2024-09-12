<?php
namespace App\Controllers;

use App\Controller;
use App\Models\ProductModel;
use App\Middleware\AuthMiddleWare;

class ProductController extends Controller
{
    protected $authMiddleware;

    public function __construct(){
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
    }
    public function product($id)
    {
        $isLoggedIn = $this->authMiddleware->handle();
        try{
            $product = ProductModel::findbyId($id);

            if($product){
                $this->render('/Product/index', [
                    'product' => $product,
                    'isLoggedIn' => $isLoggedIn
                ]);
            }else{
                throw new \Exception("Product tidak ditemukan", 404);
            }
        }catch(\Exception $e){
            $this->render('/Product/error', [
                'error' => $e->getMessage(),
                'isLoggedIn' => $isLoggedIn
            ]);
        }
    }

    public function getProduct($id){
        try{
            $product = ProductModel::findbyId($id);

            if($product){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $product
                ]);
            }else{
                throw new \Exception("Product tidak ditemukan", 404);
            }
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getAllProduct(){
        try{
            $product = ProductModel::getAll();

            if($product){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $product
                ]);
            }else{
                throw new \Exception("Product tidak ditemukan", 404);
            }

        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
  
}
