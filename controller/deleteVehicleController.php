<?php
use model\classes\Vehicle;
use model\database\VehicleDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
session_start();

if (isset($_POST['np']) && trim($_POST['np']) != "") {
    $ownerDao = VehicleDao::getInstance();
    $vehicleDeleted = $ownerDao->deleteVehicleByNp($_POST['np']);
    if ($vehicleDeleted) {
        echo json_encode(["Result" => "Vehicle successfully deleted."]);
    }
    else {
        echo json_encode(["Result" => "An error occurred, please try again later."]);
    }
}
else {
    echo json_encode(["Result" => "You can't leave empty fields!"]);
}