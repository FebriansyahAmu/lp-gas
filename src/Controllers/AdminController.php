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
            // $this->checkRefer();
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



    public function getRiwayatPembelian(){
        try{
            //$this->checkRefer();
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
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getCountUsers(){
        try{
            // $this->checkRefer();

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

    private function checkRefer(){
        $allowedReferer = "http://localhost:3000";
        if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $allowedReferer) === false) {
           header('Location: /');
           exit;
        }
    }

}