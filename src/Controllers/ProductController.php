<?php
namespace App\Controllers;

use App\Controller;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function product($id)
    {
        try{
            $product = ProductModel::findbyId($id);

            if($product){
                $this->render('/Product/index', ['product' => $product]);
            }else{
                throw new \Exception("Product tidak ditemukan", 404);
            }
        }catch(\Exception $e){
            $this->render('/Product/error', ['error' => $e->getMessage()]);
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
  
}
