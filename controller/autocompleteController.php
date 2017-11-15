<?php
use model\database\OwnerDao;
use model\database\VehicleDao;

function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}

if (isset($_GET['type']) && isset($_GET['value'])) {
    try {
        $ownerDao = OwnerDao::getInstance();
        $vehicleDao = VehicleDao::getInstance();
        $type = $_GET['type'];
        $searchValue = $_GET['value'];
        if ($type == "egn") {
            $suggestions = $ownerDao->getEgnSuggestions($searchValue);
            echo json_encode(['suggestions' => $suggestions]);
        }
        elseif ($type == "np") {
            $suggestions = $vehicleDao->getNumberplateSuggestions($searchValue);
            echo json_encode(['suggestions' => $suggestions]);
        }
        else {
            echo "";
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}