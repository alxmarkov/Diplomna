<?php
$username = $_SESSION['user']->getUsername();
$greeting = "<label>Welcome " . $username . "!</label>";
$loginButtonText = "Log Out";
$loginButtonAction = "../../controller/logoutController.php";
$loginButtonDisabled = "";
$loginButtonType = "submit";