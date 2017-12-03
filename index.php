<?php
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once $className . '.php';
}
session_start();
$page = "";
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    switch ($user->getRole()) {
        case "11": {
            $page = "view/admin/adminPanel.php";
            break;
        }
        case "22": {
            $page = "view/vehicle/vehMgmtPanel.php";
            break;
        }
        case "33": {
            $page = "view/vehicle/insPanel.php";
            break;
        }
        case "44": {
            $page = "view/vehicle/motPanel.php";
            break;
        }
        case "55": {
            $page = "view/vehicle/taxPanel.php";
            break;
        }
        case "66": {
            $page = "view/admin/invPanel.php";
            break;
        }
        default : {
            $page = "view/public/login.php";
        }
    }

    header("Location: $page");
}
else {
    header("Location: view/public/home.php");
}
