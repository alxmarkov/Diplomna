<?php
use model\classes\Owner;
use model\database\OwnerDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
session_start();

if (isset($_GET['egn']) && trim($_GET['egn']) != "") {
    try {
        $ownerDao = OwnerDao::getInstance();
        $owner = $ownerDao->getByEGN($_GET['egn']);
        echo json_encode($owner);
    }
    catch (PDOException $e) {
        echo json_encode(["Error" => "An error occurred, please try again later."]);
    }
}
else {
    echo json_encode("wtf");
}