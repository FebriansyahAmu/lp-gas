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
            'message'=> 'Email tidak valid'
        ],
        'phone' => [
            'rule' => 'required',
            'message' => 'Nomor Hp tidak boleh kosong.'
        ],
        'password' => [
            'rule'=> 'required',
            'message'=> 'Password tidak boleh kosong'
        ]
    ];

    public static function validateData($data){
        $errors = [];

        foreach(self::$validationRules as $field => $validation){
            $value = isset($data[$field]) ? $data[$field] : null;

            if($validation['rule'] === 'required' && empty($value)){
                $errors[$field] = $validation['message'];
            }

            if($validation['rule'] === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                $errors[$field] = $validation['message'];
            }
        }

        return $errors;
    }


    //cari user berdasarkan email
    public static function findByEmail($email){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE Email = ?");
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

    //simpan data user baru
    public static function create($data){
        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (Nama_Lengkap, Email, No_Hp, Password, isVerified, role) VALUES(?, ?, ?, ?, ?, ?)");
            if(!$stmt){
                throw new Exception("Failed to prepare statement: ", $db->error);
            }

            $stmt->bind_param("ssisis", $data['namalengkap'], $data['email'], $data['phone'], $data['password'], $data['isverified'], $data['role']);
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
            if($user && password_verify($password, $user['password'])){
                return $user;
            }
            return false;
        }catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }
}