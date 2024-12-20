<?php

namespace App\Controllers;
use App\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Order;
use App\Config\Midtrans;
use App\Middleware\AuthMiddleware;
use App\Models\User;
use App\Models\ProductModel;



class CheckoutController extends Controller{


    protected static $host;
    protected static $smtpEmail;
    protected static $smtpPass;
    protected static $port;

    private static function init(){
        self::$host = $_ENV['SMTP_HOST'];
        self::$smtpEmail = $_ENV['SMTP_USERNAME'];
        self::$smtpPass = $_ENV['SMTP_PASSWORD'];
        self::$port = $_ENV['SMTP_PORT'];
    }
    
    public function checkout(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try{
                $userData = AuthMiddleware::checkAuth();
                $userId = $userData['id'];

                $orderId = preg_replace('/[^A-Za-z0-9]/', '', uniqid('ORDER', true));

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

                $itemsDetail = [
                    [
                        'id' => $data['productId'],
                        'price' => $data['submittedTotalHarga'] / $data['quantity'],
                        'quantity' => $data['quantity'],
                        'name' => $jenisGas
                    ]
                ];
                
                $transactionDetails = [
                    'order_id' => $orderId,
                    'gross_amount' => $data['submittedTotalHarga']
                ];


                $customerDetails=[
                    'first_name' => $userData['namalengkap']
                ];

                $expiry = [
                    "unit" => "minutes",
                    "duration" => 5
                ];

                $transactionParams = [
                    'transaction_details' => $transactionDetails,
                    'item_details' => $itemsDetail,
                    'customer_details' => $customerDetails,
                    'expiry' => $expiry
                ];

                Midtrans::init();

                $snapToken = \Midtrans\Snap::getSnapToken($transactionParams);
                Order::updateSnapToken($orderId, $snapToken);

                echo json_encode([
                    'token' => $snapToken
                ]);
                register_shutdown_function(function() use ($orderId) {
                    $this->sendEmailNotification($orderId);
                });

            }catch(\Exception $e){
                 http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
    }


    public function checkoutCart() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("Invalid method request", 405);
            }
            $this->checkRequest();
            // Validasi autentikasi user
            $userData = AuthMiddleware::checkAuth();
            $userId = $userData['id'];
    
            // Mengambil payload data dari request body
            $dataJson = file_get_contents('php://input');
            $cartItems = json_decode($dataJson, true);
    
            if (empty($cartItems) || empty($cartItems['cart'])) {
                throw new \Exception("Tidak ada items yang dipilih", 400);
            }
    
            // Mengambil data umum seperti metode pengiriman, alamat, dan biaya pengiriman di luar loop
            $deliveryMethod = filter_var($cartItems['delivery_method'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $alamat = filter_var($cartItems['alamat'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $deliveryFee = filter_var($cartItems['delivery_fee'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $deliveryFee = (int)$deliveryFee;
            $delivfee = 2000;
            if ($deliveryMethod === 'regular') {
                $alamat = NULL;
                $deliveryFee = 0;
            }
    
            // Inisialisasi variabel
            $orderId = preg_replace('/[^A-Za-z0-9]/', '', uniqid('ORDER', true));
            $totalHarga = 0;
            $itemsDetail = [];
    
            foreach ($cartItems['cart'] as $item) {
                $data = [
                    'productId' => filter_var($item['product_id'], FILTER_VALIDATE_INT),
                    'id_user' => $userId,
                    'quantity' => filter_var($item['quantity'], FILTER_VALIDATE_INT),
                    'delivery_method' => $deliveryMethod,
                    'alamat' => $alamat,
                    'submittedTotalHarga' => filter_var($item['total_harga'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'status' => 'pending',
                    'deliveryFee' => $deliveryFee,
                    'order_id' => $orderId
                ];
    
                $jenisGas = filter_var($item['jenis_gas'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                // Validasi data order per item
                $validationResult = Order::validationCartCO($data);
                if ($validationResult['status'] === 'error') {
                    http_response_code(400);
                    echo json_encode($validationResult);
                    exit();
                }
    
                // Akumulasi total harga untuk semua item
                $totalHarga += $data['submittedTotalHarga'];
                // Simpan setiap item ke dalam database
                $createOrder = Order::createOrder($data);
    
                // Tambahkan detail item ke dalam array untuk Midtrans
                $itemsDetail[] = [
                    'id' => $data['productId'],
                    'price' => $data['submittedTotalHarga'] / $data['quantity'], // Harga per unit
                    'quantity' => $data['quantity'],
                    'name' => $jenisGas
                ];
            }


            $totalQuantity = array_sum(array_column($cartItems['cart'], 'quantity'));

            // Hitung biaya pengiriman berdasarkan total kuantitas
            $calculatedDeliveryFee = 2000 * $totalQuantity;
    
            // Validasi biaya pengiriman
            if ($deliveryMethod !== 'regular') {
                if ($deliveryFee !== $calculatedDeliveryFee) {
                    throw new \Exception("Biaya pengiriman tidak valid. Diharapkan: $calculatedDeliveryFee, Diterima: $deliveryFee", 400);
                }
            } else {
                $deliveryFee = 0; // Jika menggunakan metode pengiriman regular
            }
    
            if ($totalHarga > 0) {
                $totalHarga += $deliveryFee; // Tambahkan biaya pengiriman hanya sekali
            }
            
            // Menambahkan biaya pengiriman ke dalam detail item
            if ($deliveryFee > 0) {
                $itemsDetail[] = [
                    'id' => 'delivery_fee', // Identifier untuk delivery fee
                    'price' => $delivfee, // Biaya pengiriman
                    'quantity' => $totalQuantity, // Jumlah bisa dianggap 1
                    'name' => 'Delivery Fee' // Nama untuk ditampilkan
                ];
            }
    
            // Menyiapkan parameter transaksi untuk Midtrans
            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => $totalHarga // Total seluruhnya termasuk biaya pengiriman
            ];
    
            $customerDetails = [
                'first_name' => $userData['namalengkap'],
            ];

            $expiry = [
                "unit" => "minutes",
                "duration" => 5
            ];

    
            // Parameter transaksi untuk Midtrans Snap
            $transactionParams = [
                'transaction_details' => $transactionDetails,
                'item_details' => $itemsDetail,
                'customer_details' => $customerDetails,
                'expiry' => $expiry
            ];
    
            // Inisialisasi Midtrans dan mendapatkan Snap Tok
            Midtrans::init();
            $snapToken = \Midtrans\Snap::getSnapToken($transactionParams);
    
            // Update Snap Token di database untuk order ini
            Order::updateSnapToken($orderId, $snapToken);
    
            // Kirimkan Snap Token kembali ke client
            header('Content-Type: application/json');
            echo json_encode([
                'token' => $snapToken
            ]);

            register_shutdown_function(function() use ($orderId) {
                $this->sendEmailNotification($orderId);
            });
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    

    private function sendEmailNotification($orderId){
        try{

            $orderedItems = Order::getOrderbyOID($orderId);
            if (!$orderedItems) {
                throw new \Exception("Order ID tidak ditemukan", 404);
            }
    
            $toEmail = 'abdulrahmanpkgas@gmail.com';
            self::init();
            
            // Konfigurasi PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = self::$host;
            $mail->SMTPAuth = true;
            $mail->Username = self::$smtpEmail;
            $mail->Password = self::$smtpPass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = self::$port;
            
            $mail->setFrom('nvlysys@gmail.com', 'PKGas-Abdullah');
            $mail->addAddress($toEmail);
            
            $mail->isHTML(true);
            $mail->Subject = 'Pesanan yang masuk';
            
            // Mulai pembuatan isi email dalam HTML
            $totalHarga = 0;
            $tableRows = '';
    
            // Buat baris tabel untuk setiap item dalam pesanan
            foreach ($orderedItems as $item) {
                $tableRows .= "
                    <tr>
                        <td>{$item['id_Order']}</td>
                        <td>{$item['Jenis_gas']}</td>
                        <td>{$item['Qty']}</td>
                        <td>{$item['totalharga']}</td>
                        <td>{$item['created_at']}</td>
                    </tr>
                ";
                $totalHarga += $item['totalharga'];
            }
    
            // Gabungkan alamat dan deskripsi jika ada, atau kosongkan jika tidak ada
            $alamatPengiriman = $orderedItems[0]['Detail_alamat'] && $orderedItems[0]['Description'] 
                ? "{$orderedItems[0]['Detail_alamat']} - {$orderedItems[0]['Description']}"
                : "Tidak ada alamat";
    
            $biayaPengiriman = $orderedItems[0]['delivery_fee'] == 0 ? "-" : $orderedItems[0]['delivery_fee'];
            
            // Rangkai HTML email
            $mail->Body = "
                <h2>Detail Pesanan yang Masuk</h2>
                <table border='1' cellpadding='8' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>Jenis Gas LPG</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Tanggal Pemesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$tableRows}
                    </tbody>
                </table>
                <br>
                <p><strong>Alamat Pengiriman:</strong> {$alamatPengiriman}</p>
                <p><strong>Biaya Pengiriman:</strong> {$biayaPengiriman}</p>
                <p><strong>Total Harga:</strong> {$totalHarga}</p>
            ";
    
            // Kirim email
            $mail->send();
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function handleNotification() {
        try {
            $jsonResult = file_get_contents('php://input');
            $notification = json_decode($jsonResult);
            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
    
            // Update status transaksi di database
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                Order::updateOrderStatus($orderId, 'paid');
                Order::updateSnapToken($orderId, NULL);
            } elseif ($transactionStatus == 'pending') {
                Order::updateOrderStatus($orderId, 'pending');
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                Order::deleteExpireOrder($orderId);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
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
