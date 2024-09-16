<?php

namespace App\Config;
use Dotenv\Dotenv;

class Midtrans{

    private static $ServerKey;

    public static function secret(){
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        self::$ServerKey = $_ENV['SERVER_KEY'];
    }

    public static function init(){
        self::secret();
        \Midtrans\Config::$serverKey = self::$ServerKey;
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }
}