<?php

namespace App\Controllers;
use App\Controller;
use App\Models\Order;
use App\Config\Midtrans;
use App\Middleware\AuthMiddleware;
use App\Models\User;
use App\Models\ProductModel;



class CheckoutController extends Controller{

    

    public function checkout(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try{
                $userData = AuthMiddleware::checkAuth();
                $userId = $userData['id'];

                $data = [
                    'productId' => filter_input(INPUT_POST, 'Id_gas', FILTER_VALIDATE_INT),
                    'id_user' => $userId,
                    'quantity' => filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT),
                    'delivery_method' => filter_input(INPUT_POST, 'delivery_method', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'alamat' => filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'submittedTotalHarga' => filter_input(INPUT_POST, 'total_harga', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'deliveryFee' => filter_input(INPUT_POST, 'delivery_fee', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'status' => 'pending',
                ];

                //check stok apakah tersedia atau tidak
                // $checkStok = ProductModel::checkStok($data['productId']);
                // if(!$checkStok){
                //     http_response_code(400);
                //     echo json_encode([
                //         'status' => 'error',
                //         'message' => 'Stok produk habis'
                //     ]);
                // }

                //validasi data input 
                $validationResult = Order::validateOrder($data);
                if($validationResult['status'] === 'error'){
                    http_response_code(400);
                    echo json_encode($validationResult);
                    exit;
                }

                $createOrder = Order::createOrder($data);

                // if ($createOrder) {
                //     http_response_code(201);
                //     echo json_encode([
                //         'status' => 'success',
                //         'message' => 'Order created successfully'
                //     ]);
                // } else {
                //     http_response_code(400);
                //     echo json_encode([
                //         'status' => 'error',
                //         'message' => 'Failed to create order'
                //     ]);
                // }

                //Integrasi dengan midtrans
                //parameter untuk transaksi
                $transactionDetails = [
                    'order_id' => uniqid('ORDER-', true),
                    'gross_amount' => $data['submittedTotalHarga']
                ];

                $itemsDetail = [
                    [
                        'id' => $data['productId'],
                        'price' => $data['submittedTotalHarga'],
                        'quantity' => $data['quantity'],
                        'name' => 'gas' //not done yet
                    ]
                ];
                

                $customerDetails=[
                    'first_name' => $userData['namalengkap']
                ];

                $transactionParams = [
                    'transaction_details' => $transactionDetails,
                    'item_details' => $itemsDetail,
                    'customer_details' => $customerDetails,
                ];

                Midtrans::init();

                $snapToken = \Midtrans\Snap::getSnapToken($transactionParams);
                echo json_encode([
                    'token' => $snapToken
                ]);


            }catch(\Exception $e){
                 http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
    }
}
