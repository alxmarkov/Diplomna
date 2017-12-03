<?php
use model\database\UserDao;
use model\classes\User;
use model\database\AdminDao;

function __autoload($className)
{
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}

$message = "";
$lastAddedUsers = "";
$lastLogEntries = "";

if (isset($_POST['Username'])
    && trim($_POST['Username']) != ""
    && isset($_POST['Password'])
    && trim($_POST['Password']) != ""
    && isset($_POST['ConfirmPassword'])
    && trim($_POST['ConfirmPassword']) != ""
    && isset($_POST['Role'])
    && trim($_POST['Role']) != "") {

    $newUser = $_POST['Username'];
    $newPass = $_POST['Password'];
    $confirmNewPass = $_POST['ConfirmPassword'];
    $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);
    $newRole = $_POST['Role'];
    $newActive = "YES";
    $dateAdded = date("Y-m-d h:i:sa");
    if ($newPass !== $confirmNewPass) {
        $message = "The entered passwords do not match!";
    }

    switch ($newRole) {
        case "administrator" : {
            $newRole = 11;
            break;
        }
        case "vehiclemanager" : {
            $newRole = 22;
            break;
        }
        case "insurarncemanager" : {
            $newRole = 33;
            break;
        }
        case "motmanager" : {
            $newRole = 44;
            break;
        }
        case "taxmanager" : {
            $newRole = 55;
            break;
        }
        case "investigator" : {
            $newRole = 66;
            break;
        }
        default : {
            $message = "Please enter a valid user role!";
            break;
        }
    }
} else {
    $message = "You can't leave empty fields!";
}


if ($message == "") {
    try {
        $userDao = UserDao::getInstance();
        $user = new User(null, $newUser, $newPass, $newRole, null, null);
        $userDao->addUser($user);
        $message = "User successfully added.";
        $adminDao = AdminDao::getInstance();
        $userDao = UserDao::getInstance();
        $lastAddedUsers = $userDao->getLastAddedUsers();
        $lastLogEntries = $adminDao->getLastFiveLogEntries();
    }
    catch (PDOException $e) {
        $message = "An error occurred, please try again later!";
    }
}
echo json_encode(["Result" => $message, "Users" => $lastAddedUsers, "Log" => $lastLogEntries]);
