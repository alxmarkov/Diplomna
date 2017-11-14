<?php
use model\database\UserDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
session_start();
$currentDate = date("Y-m-d h:i:sa");
$loggingUser = $_SESSION["username"];

$userDao = UserDao::getInstance();
$userDao->userLogout();
session_unset();
session_destroy();
header("Location: ../");