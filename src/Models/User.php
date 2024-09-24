<?php

namespace App\Models;

use App\Core\Database;

class User{
    protected static $table = 'ec_user';


    //Validasi request rule
    private static $validationRules = [
        'namalengkap' => [
            'rule' => 'required',
            'message' => 'Nama lengkap tidak boleh kosong.'
        ],
        'email' => [
            'rule' => 'email',
            'message'=> 'Email tidak valid.'
        ],
        'phone' => [
            'rule' => 'required',
            'message' => 'Nomor Hp tidak boleh kosong.'
        ],
        'password' => [
            'rule'=> ['required', 'min_length' => 8],
            'message'=> [
                'required' => 'Password tidak boleh kosong.',
                'min_length' => 'Password harus minimal 8 karakter.'
            ]
        ]
    ];
    
    public static function validateData($data){
        $errors = [];
    
        foreach(self::$validationRules as $field => $validation){
            $value = isset($data[$field]) ? $data[$field] : null;
    
            // Validasi 'required'
            if(is_array($validation['rule']) && in_array('required', $validation['rule']) && empty($value)){
                $errors[$field] = $validation['message']['required'];
            } elseif($validation['rule'] === 'required' && empty($value)){
                $errors[$field] = $validation['message'];
            }
    
            // Validasi 'email'
            if($validation['rule'] === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                $errors[$field] = $validation['message'];
            }
    
            // Validasi 'min_length' untuk password
            if(isset($validation['rule']['min_length']) && strlen($value) < $validation['rule']['min_length']){
                $errors[$field] = $validation['message']['min_length'];
            }
        }
    
        return $errors;
    }
    


    //cari user berdasarkan email
    public static function findByEmail($email){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT user_id, Nama_lengkap, Email, Password, role FROM " . self::$table . " WHERE Email = ?");
            if(!$stmt){
                throw new Exception("Failed to prepare statement: ", $db->error);
            }

            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new Exception("Failed to execute query: ", $stmt->error);
            }

            return $result->fetch_assoc();
        }catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
    
    public static function isVerified($email){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT isVerified FROM " . self::$table . " WHERE email = ?");
            if(!$stmt){
                throw new Exception("Failed to prepare statement: ", $db->error);
            }

            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if(!$result){
                throw new Exception("Failed to execute query: ", $stmt->error);
            }

            $userData = $result->fetch_assoc();
            if($userData && $userData['isVerified'] == 1){
                return true;
            }
            
            return false;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    //simpan data user baru
    public static function create($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (Nama_Lengkap, Email, No_Hp, Password, isVerified, role, token) VALUES(?, ?, ?, ?, ?, ?, ?)");
            if(!$stmt){
                throw new Exception("Failed to prepare statement: ", $db->error);
            }

            $stmt->bind_param("ssisiss", $data['namalengkap'], $data['email'], $data['phone'], $data['password'], $data['isverified'], $data['role'], $data['token']);
            $success = $stmt->execute();
            if(!$success){
                throw new Exception("Failed to execute query", $stmt->error);
            }

            return true;
        }catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function verifyUser($email, $password){
        try{
            $user = self::findByEmail($email);
            if($user && password_verify($password, $user['Password'])){
                return $user;
            }
            return false;
        }catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getAllCustomer(){
        try{
            $db = Database::getConnection();

            $role = 'user';
            $stmt = $db->prepare("SELECT user_id, Nama_lengkap, Email, No_Hp FROM " . self::$table . " WHERE role = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('s', $role);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function findByToken($token){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT isVerified, token FROM " . self::$table . " WHERE token = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('s', $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return $result->fetch_assoc();
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function verifiedToken($token){
        try{
            $db = Database::getConnection();
            $isverified = 1;
            $stmt = $db->prepare("UPDATE " . self::$table . " SET isVerified = ?, token = NULL WHERE token=?");

            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }
            $stmt->bind_param('is', $isverified, $token);
            $success = $stmt->execute();

            if(!$success){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return true;

        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function resendVerif($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE " . self::$table . " SET token = ? WHERE email = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('ss', $data['token'], $data['email']);
            $success = $stmt->execute();

            if(!$stmt){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function tokenResPas($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE " . self::$table . " SET res_token = ? WHERE Email = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('ss', $data['repas-token'], $data['email']);
            $success = $stmt->execute();
            if(!$success){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return true;
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function checkResToken($token){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT res_token FROM " . self::$table . " WHERE res_token = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('s', $token);
            $stmt->execute();
            $result = $stmt->get_result();
            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return $result->fetch_assoc();
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function newPassword($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE " . self::$table . " SET Password = ?, res_token = NULL WHERE res_token = ?");
            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }
            $stmt->bind_param('ss', $data['password'], $data['res-token']);
            $success = $stmt->execute();
            if(!$success){
                throw new \Exception("Failed to execute query", $stmt->error);
            }

            return true;
        }catch(\Exception $e){
            error_log($e->getMessage);
            return false;
        }
    }

    public static function countUsers(){
        try{
            $db = Database::getConnection();
            $role = 'user';
            $stmt = $db->prepare("SELECT count(user_id) FROM " . self::$table . " WHERE role = ?");

            if(!$stmt){
                throw new \Exception("Failed to prepare statement", $db->error);
            }

            $stmt->bind_param('s', $role);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$result){
                throw new \Exception("Failed to execute query", $stmt->error);
            }
            
            return $result->fetch_assoc();
        }catch(\Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
}