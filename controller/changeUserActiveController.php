<?php
use model\database\UserDao;
use model\classes\User;
use model\database\AdminDao;

function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}

$message = "";
$lastLogEntries = "";

if (!isset($_POST['Username'])) {
    $message = "Please enter a valid Username!";
}
elseif (!isset($_POST['action'])) {
    $message = "Invalid Action!";
}
else {
    $manipulatedUser = $_POST['Username'];
    if($_POST['action'] == "actUser") {
        $userActive = "YES";
        $resultMessage = "activated successfully";
        $logMessage = "Activated User";
    }
    elseif ($_POST['action'] == "deactUser") {
        $userActive = "NO";
        $resultMessage = "deactivated successfully";
        $logMessage = "Deactivated User";
    }
    else {
        $message = "Invalid Action!";
        json_encode(["Result" => $message]);
        exit();
    }
    try {
        $userDao = UserDao::getInstance();
        $userDao->changeUserActive($manipulatedUser, $userActive, $logMessage);
        $message = "Success!";
        $adminDao = AdminDao::getInstance();
        $lastLogEntries = $adminDao->getLastFiveLogEntries();
    }
    catch (PDOException $e) {
        $message = "An error occurred, please try again later!";
    }
    echo json_encode(["Result" => $message, "Log" => $lastLogEntries]);
}