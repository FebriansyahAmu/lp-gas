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

                $orderId = uniqid('ORDER-', true);

                $data = [
                    'productId' => filter_input(INPUT_POST, 'Id_gas', FILTER_VALIDATE_INT),
                    'id_user' => $userId,
                    'quantity' => filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT),
                    'delivery_method' => filter_input(INPUT_POST, 'delivery_method', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'alamat' => filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'submittedTotalHarga' => filter_input(INPUT_POST, 'total_harga', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'deliveryFee' => filter_input(INPUT_POST, 'delivery_fee', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'status' => 'pending',
                    'order_id' => $orderId
                ];
                $jenisGas = filter_input(INPUT_POST, 'jenis_gas', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                //validasi data input 
                $validationResult = Order::validateOrder($data);
                if($validationResult['status'] === 'error'){
                    http_response_code(400);
                    echo json_encode($validationResult);
                    exit();
                }

                $createOrder = Order::createOrder($data);

                $transactionDetails = [
                    'order_id' => $orderId,
                    'gross_amount' => $data['submittedTotalHarga']
                ];

                $itemsDetail = [
                    [
                        'id' => $data['productId'],
                        'price' => $data['submittedTotalHarga'],
                        'quantity' => $data['quantity'],
                        'name' => $jenisGas
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
                Order::updateSnapToken($orderId, $snapToken);

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


    public function handleNotification(){
        try{
            $jsonResult = file_get_contents('php://input');
            $notification = json_decode($jsonResult);

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;

            // Periksa status transaksi dan update status pesanan di database
            if($transactionStatus == 'capture' || $transactionStatus == 'settlement'){
                    Order::updateOrderStatus($orderId, 'paid');
                    Order::updateSnapToken($orderId, NULL);
                } elseif ($transactionStatus == 'pending') {
                    Order::updateOrderStatus($orderId, 'pending');
                } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                    Order::updateOrderStatus($orderId, 'failed');
                }

            // Response ke Midtrans
            header('Content-Type: application/json');
            return json_encode(['status' => 'success']);
        }catch(\Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


}
