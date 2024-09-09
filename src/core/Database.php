<?php

namespace App\Core;

class Database{
    private static $connection = null;

    public static function getConnection(){
        if(self::$connection === null){
            $config = require __DIR__ . '/../config.php';
            $dbConfig = $config['database'];

            $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";

            self::$connection = new \mysqli(
                $dbConfig['host'],
                $dbConfig['username'],
                $dbConfig['password'],
                $dbConfig['dbname']
            );

            if(self::$connection->connect_error){
                die('Koneksi database gagal: ' . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }
}