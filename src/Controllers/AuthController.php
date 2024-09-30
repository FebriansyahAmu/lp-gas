<?php

namespace App\Controllers;
use App\Controller;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Helpers\JwtHelper;
use App\Middleware\AuthMiddleware;
use Dotenv\Dotenv;

class AuthController extends Controller
{

    protected $authMiddleware;
    protected static $host;
    protected static $smtpEmail;
    protected static $smtpPass;
    protected static $port;

    //Inisiasi method untuk memanggil key di file .env
    public static function init(){
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        self::$host = $_ENV['SMTP_HOST'];
        self::$smtpEmail = $_ENV['SMTP_USERNAME'];
        self::$smtpPass = $_ENV['SMTP_PASSWORD'];
        self::$port = $_ENV['SMTP_PORT'];
    }

    //method untuk memanggil middlewarare
    public function __construct(){
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
    }

    //method untuk menampilkan halamana Login
    public function login()
    {
        $data = []; 
        $this->render('/Login/index', $data, 'Layout/standardLayout'); 
    }

    //method untuk menampilkan halaman register
    public function register(){
        $data = [];
        $this->render('/Register/index', $data, 'Layout/standardLayout');
    }

    //method untuk menampilkan halaman verifikasi sukses
    public function verificationSuccess(){
        $data = [];
        $this->render('/verification-sukses/index', $data, 'Layout/standardLayout');
    }

    //method untuk menampilkan halaman lupa password
    public function lupaPassword(){
        $data = [];
        $this->render('/Lupa-password/index', $data, 'Layout/standardLayout');
    }

    //method ini berfungsi untuk mengambil request untuk daftar akun baru
    public function registerAct(){
        //Cek apakah requestnya sesuai yaitu POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try{ //Menggunakan try catch sebagai error handling
                //inisiasi array untuk menangkap request user, dan memvalidasi inputnya 
                $data = [
                    'namalengkap' => filter_input(INPUT_POST, 'namalengkap', FILTER_SANITIZE_SPECIAL_CHARS),
                    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                    'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS),
                    'password' => filter_input(INPUT_POST, 'password', FILTER_DEFAULT),
                ];

                //validasi Data yang diinputkan oleh user
                $errors = User::validateData($data);
                if(!empty($errors)){
                    header('Content-Type: application/json');
                    http_response_code(422);
                    echo json_encode([
                        'status' => 'error',
                        'message' => $errors
                    ]);
                    return;
                }
                
                //lakukan pengecekan email apakah email yang dikirim telah terdaftar atau belum
                if(User::findByEmail($data['email'])){
                    header('Content-Type: application/json');
                    http_response_code(409);
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Email sudah terdaftar'
                    ]);
                    return;
                }

                //lakukan hashing password dan set isVerifiednya ke 0
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                $data['isverified'] = 0;
                $data['token'] = bin2hex(random_bytes(32));
                $data['role'] = 'user';

                if(User::create($data)){ //panggil method create untuk membuat akun baru
                    //kirim link verifikasi email berdasarkan email yang diinputkan oleh user
                    $sendVerifEmail = self::sendVerificationEmail($data['email'], $data['token'], 'verification');
                    if($sendVerifEmail){
                        http_response_code(201);
                        echo json_encode([
                        'status' =>'success',
                            'message' => 'Register berhasil, silahkan cek email anda untuk verifikasi'
                        ]);
                    }else{
                        throw new \Exception('Akun berhasil dibuat, tetapi gagal mengirim email verifikasi. Silahkan coba lagi nanti.', 500);
                    }
                }else{
                    throw new \Exception('Gagal membuat akun, Silahkan coba lagi nanti', 500);
                }
            }catch(\Exception $e){ //Tangkap semua error dan tampilkan dalam header application/json
                header('Content-Type: application/json');
                http_response_code($e->getCode() ? : 500);
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        }else{ //Jika REQUEST_METHOD tidak sesuai dalam arti, tidak POST, maka akan muncul error invalid method
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    //Method untuk login
    public function loginAct(){
        try{ //Gunakan try & catch untuk error handling
            //lakukan pengecekan request method apakah post atau bukan.
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new Exception('Method not allowed', 405);
            }

            //Validasi input dari user 
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
        
            if(!$email || !$password){
                throw new \Exception("Email or password cannot be empty", 400);
            }
            
            //cek apakah email dan username sesuai dengan yang ada di database
            $user = User::verifyUser($email, $password);
            if(!$user){
                throw new \Exception("Invalid credentials", 401);
            }

            //lakukan pengecekan apakah user sudah melakukan verifikasi email?
            $isVerified = User::isVerified($email);
            if(!$isVerified){
                header('Content-Type: application/json');
                // http_response_code(403);
                echo json_encode([
                    'status' => 'unverified',
                    'message' => 'Akun anda belum verifikasi. Silahkan cek email anda untuk verifikasi',
                    'email' => $email
                ]);
                exit();
            }
            
            //jika sudah melalui proses sebelumnnya, ambil data id, namalengkap, role
             $data = [
                'id' => $user['user_id'],
                'namalengkap' => $user['Nama_lengkap'],
                'role' => $user['role']
             ];

             //Buat token JWT untuk menyimpan $data sebelumnya, untuk digunakan dalam keperluan mengakses halaman yang di proteksi
             $token = JwtHelper::generateToken($data);

             //simpan authToken di cookie, NOTE::HARUS COOKIE HTTP_ONLY
             setcookie('authToken', $token, [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
             ]);

            //lakukan validasi, dan redirect ke masing" halaman sesuai dengan role yang ada
            if($user['role'] === 'admin'){
                echo json_encode([
                    'status' => 'success',
                    'redirect' => '/dashboard'
                ]);
                exit();
             }else if($user['role'] === 'user'){
                echo json_encode([
                    'status' => 'success',
                    'redirect' => '/account'
                ]);
             }


        }catch(\Exception $e){//Tangkap error dengan menggunakan catch
            http_response_code($e->getCode() ? $e->getCode() : 400);

            echo json_encode([
                'status' => 'error',
                'message'=> $e->getMessage()
            ]);
        }
    }

    //Method untuk chekauth apakah user sudah login atau belum yang mana data ini akan diperlukan nanti
    public function checkAuthStatus(){
        try {
            $this->checkRefer();
            $auth = $this->authMiddleware->handle();
    
            header('Content-Type: application/json');
    
            // Kembalikan nilai boolean secara langsung
            echo json_encode([
                "auth" => $auth ? true : false  // Mengembalikan boolean, bukan string
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    

    //Method untuk mengirim verifikasi email
    private function sendVerificationEmail($toEmail, $token, $type){
        $mail = new PHPMailer();
        // $user = User::findByEmail($toEmail);

        // // Cek apakah user ditemukan
        // if (!$user) {
        //     http_response_code(404);
        //     echo json_encode([
        //         'status' => 'error',
        //         'message' => 'User tidak ditemukan'
        //     ]);
        //     return;
        // }
    
        // // Cek apakah sudah lewat 1 menit sejak pengiriman terakhir
        // $lastRequest = strtotime($user['last_verification_request']);
        // $currentTime = time();
        // $timeDiff = $currentTime - $lastRequest;
    
        // if ($lastRequest && $timeDiff < 60) {
        //     // Jika belum lewat 1 menit
        //     http_response_code(429); // 429 Too Many Requests
        //     echo json_encode([
        //         'status' => 'error',
        //         'message' => 'Anda hanya bisa meminta verifikasi setiap 1 menit.'
        //     ]);
        //     return;
        // }
        try{
            self::init();
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
            $mail->Subject = 'Verifikasi Email';
            
            if ($type === 'verification') {
                $verificationLink = "https://1a1a-2400-9800-c21-2d2-35c5-8d05-655a-7f3.ngrok-free.app/verifikasi-email/$token";
                $mail->Body = "Klik link berikut untuk memverifikasi akun anda: <a href='$verificationLink'>$verificationLink</a>";
                $mail->AltBody = "Klik link berikut untuk memverifikasi akun Anda: $verificationLink";
            } elseif ($type === 'reset_password') {
                $resetLink = "https://1a1a-2400-9800-c21-2d2-35c5-8d05-655a-7f3.ngrok-free.app/auth/password-reset/$token";
                $mail->Body = "Klik link berikut untuk reset password anda: <a href='$resetLink'>$resetLink</a>";
                $mail->AltBody = "Klik link berikut untuk reset password Anda: $resetLink";
            }

            $mail->send();
            return true;
        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function emailVerification($token){
        try{
            $userToken = User::findByToken($token);
            if(!$userToken){
                throw new \Exception("Token tidak ditemukan, silahkan coba lagi nanti");
                exit();
            }

            if(is_null($userToken['token']) && $userToken['isVerified'] == 0){
                header('Location: /verifikasi-gagal');
            }

            $verifyUser = User::verifiedToken($token);
            if(!$verifyUser){
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi nanti", 500);
            }

            header('Location: /verifikasi-sukses');
            exit();

        }catch(\Exception $e){
            header('Content-Type: application/json');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            
        }
    }

    //resend link verification
    public function resendLink(){
        try{
            
            $token = bin2hex(random_bytes(32));
            $data = [
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'token' =>  $token
            ];

            $resendVerificationLink = self::sendVerificationEmail($data['email'], $data['token'], 'verification');
            if($resendVerificationLink){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Link verifikasi telah dikirim, silahkan cek email anda'
                ]);
            }else{
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi nanti", 500);
                exit();
            }

            $updateToken = User::resendVerif($data);
            if(!$updateToken){
                throw new \Exception("invalid Data", 400);
            }
        }catch(\Exception $e){
            header('Content-Type: application/jso');
            http_response_code($e->getCode() ? : 500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logoutUsers(){
        setcookie('authToken', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        header('Location: /login');
        exit();
    }


    //Forget Password
    public function forgetPassword(){
        try{
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                throw new \Exception("Method not allowed", 405);
            }

            $resetToken = bin2hex(random_bytes(32));
            $data = [
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'repas-token' => $resetToken
            ];

            $checkEmail = User::findByEmail($data['email']);
            if(!$checkEmail){
                throw new \Exception("Email anda tidak ditemukan", 404);
                exit();
            }

            if(User::tokenResPas($data)){
                $sendResetLink = self::sendVerificationEmail($data['email'], $data['repas-token'], 'reset_password');
                if($sendResetLink){
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Link untuk reset password telah dikirim, silahkan cek email anda'
                    ]); 
                }else{
                    throw new \Exception("Terjadi kesalahan, silahkan coba lagi nanti", 500);
                }
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

    public function resetPassword($token){
        try{
            $resToken = User::checkResToken($token);
            if(!$resToken){
                throw new \Exception("Invalid token", 400);
            }
            $data = ['resToken' => $resToken['res_token']];
            $this->render('/Lupa-password/reset-password/index', $data, 'Layout/standardLayout');
        }catch(\Exception $e){
            http_response_code($e->getCode() ? : 500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function newPassword(){
        try{
            if($_SERVER['REQUEST_METHOD'] !== "POST"){
                throw new \Exception("method not allowed", 400);
            }

            $data = [
                'res-token' => filter_input(INPUT_POST, 'resToken', FILTER_SANITIZE_STRING),
                'password' => filter_input(INPUT_POST, 'password', FILTER_DEFAULT)
            ];

            if(strlen($data['password']) < 8){
                throw new \Exception("Password minimal 8 karakter", 400);
            }

            $checkResToken = User::checkResToken($data['res-token']);
            if(!$checkResToken){
                throw new \Exception("Token invalid", 400);
            }

            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $updatePassword = User::newPassword($data);
            if($updatePassword){
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Password berhasil diubah'
                ]);
            }



        }catch(\Exception $e){
            http_response_code($e->getCode() ? : 500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message'=> $e->getMessage()
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
