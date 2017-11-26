<?php
use model\classes\Vehicle;
use model\database\VehicleDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
session_start();

if (isset($_GET['np']) && trim($_GET['np']) != "") {
    try {
        $vehicleDao = \model\database\VehicleDao::getInstance();
        $vehicle = $vehicleDao->getByNP($_GET['np']);
        echo json_encode($vehicle);
    }
    catch (PDOException $e) {
        echo json_encode(["Result" => "An error occurred, please try again later."]);
    }
}
else {
    echo json_encode(["Result" => "You can't leave empty fields!"]);
}