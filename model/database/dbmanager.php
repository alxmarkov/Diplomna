<?php

define('DB_IP', "127.0.0.1");
define('DB_PORT', "3306");
define('DB_USER', "root");
//define('DB_PASS', "");
define('DB_NAME', "vis_database");


function getConnection(){
    $pdo = new PDO("mysql:host=".DB_IP.":".DB_PORT.";dbname=".DB_NAME, DB_USER);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
