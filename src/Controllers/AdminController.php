<?php

namespace App\Controllers;
use App\Controller;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{

    public function dashboard()
    {
        $data = [];
         $this->render('Dashboard/index', ['title' => 'Dashboard'], 'Layout/dashLayout');
    }

    public function indexGas(){
        $data = [];
        $this->render('Admin-lgas/index', $data, 'Layout/dashLayout');
    }

    public function indexDataCustomer(){
        $data = [];
        $this->render('Admin-udata/index', $data, 'Layout/dashLayout');
    }




    public function getDataCustomer(){
        try{
            $endPoint = "/data-customer";
            $this->checkReferer($endpoint);
            $this->checkRequest();
            
            $dataCustomer = User::getAllCustomer();
            if($dataCustomer){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $dataCustomer
                ]);
            }else{
                throw new \Exception("Data Customer tidak tersedia", 404);
            }

        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function getDetailOrder($orderId){
        try{
            // $endPonint = "/dashboard";
            // $this->checkReferer($endPoint);
            // $this->checkRequest();

            $detailOrder = Order::getOrderbyOID($orderId);
            if($detailOrder){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $detailOrder
                ]);
            }else{
                throw new \Exception("Detail order tidak ditemukan", 404);
            }
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function getRiwayatPembelian(){
        try{
            // $endPoint = "/dashboard";
            // $this->checkReferer($endPoint);
            // $this->checkRequest();

            $riwayatPembelian = Order::getRiwayatOrders();
            if($riwayatPembelian){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $riwayatPembelian
                ]);
            }else{
                throw new \Exception("Riwayat pembelian tidak tersedia", 404);
            }
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function getCountUsers(){
        try{
            // $endPoint = "/dashboard";
            // $this->checkReferer($endPoint);
            // $this->checkRequest();
            
            $getcountUser = User::countUsers();

            if($getcountUser){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'data' => $getcountUser
                ]);
            }else{
                throw new \Exception("Data User tidak tersedia", 404);
            }
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    private function checkReferer($endpoint){
        $allowedReferer = "https://pangkalangasabdulrahman.online";
        if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) !== 0) {
            header("Location: $endpoint");
            exit();
        }
    }

    private function checkRequest(){
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            http_response_code(403); 
            echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak diizinkan']);
            exit();
        }
    }
}