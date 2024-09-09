<?php

require '../vendor/autoload.php';
use Dotenv\Dotenv;

$router = require '../src/Routes/index.php';

 $dotenv = Dotenv::createImmutable(dirname(__DIR__));
 $dotenv->load();