<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case "11" : {
            if(isset($_POST['page'])) {
                $bodyName = $_POST['page'];
            }
            else {
                $bodyName = "adminPanel";
            }
            break;
        }
        case "22" : {
            if(isset($_POST['page'])) {
                $bodyName = $_POST['page'];
            }
            else {
                $bodyName = "vehMgmtPanel";
            }
            break;
        }

        default : {
            $bodyName = "home";
            break;
        }
    }
}
elseif (isset($_POST['page'])) {
    if($_POST['page'] != "home" && $_POST['page'] != "publicSearch" && $_POST['page'] != "loginScript") {
        $bodyName = "login";
    }
    else {
        $bodyName = $_POST['page'];
    }
}
else {
    $bodyName = "home";
}

switch ($bodyName) {
    case "login" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Log In";
        $page = "pages/login.php";
        break;
    }
    case "loginScript" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Log In";
        $page = "src/loginScript.php";
        break;
    }
    case "publicSearch" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Search Results";
        $page = "pages/publicSearch.php";
        break;
    }
    case "adminPanel" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Administration Panel";
        $page = "pages/adminPanel.php";
        break;
    }
    case "addUser" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Administration Panel";
        $page = "src/addUserScript.php";
        break;
    }
    case "changeUserActive" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Administration Panel";
        $page = "src/changeUserActive.php";
        break;
    }
    case "adminPanelLog" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Administration Panel";
        $page = "pages/adminPanelLog.php";
        break;
    }
    case "vehMgmtPanel" : {
        $topHeading = "Vehicle Information Service";
        $pageName = "Vehicle Management Panel";
        $page = "pages/vehMgmtPanel.php";
        break;
    }
    default : {
        $topHeading = "Welcome to Aleksandar Markov's";
        $pageName = "Vehicle Information Service";
        $page = "pages/home.php";
        break;
    }
}

if ($bodyName == "login") {
    $loginButtonDisabled = "w3-disabled";
    $loginButtonType = "button";
}
else {
    $loginButtonDisabled = "";
    $loginButtonType = "submit";
}

if(isset($_SESSION['username'])){
    $greeting = "<label>Welcome " . $_SESSION['username'] . "!</label>";
    $loginButtonText = "Log Out";
    $loginButtonAction = "src/logoutScript.php";

}
else {
    $greeting = "";
    $loginButtonText = "Log In";
    $loginButtonAction = "";
}


include_once ("pages/header.php");

include_once ($page);

include_once ("pages/footer.php");