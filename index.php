<?php
session_start();
$page = "";
if (isset($_SESSION["role"])) {
    switch ($_SESSION["role"]) {
        case "11": {
            $page = "view/admin/adminPanel.php";
            break;
        }
        case "22": {
            $page = "view/vehicle/vehMgmtPanel.php";
            break;
        }
        case "33": {
            $page = "view/admin/adminPanel.php";
            break;
        }
        case "44": {
            $page = "view/admin/adminPanel.php";
            break;
        }
        case "55": {
            $page = "view/admin/adminPanel.php";
            break;
        }
        case "66": {
            $page = "view/admin/adminPanel.php";
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
