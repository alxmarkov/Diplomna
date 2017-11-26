<?php
use model\classes\Owner;
use model\database\OwnerDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
session_start();

if (isset($_POST['egn']) && trim($_POST['egn']) != "") {
    $ownerDao = OwnerDao::getInstance();
    $ownerDeleted = $ownerDao->deleteOwnerByEGN($_POST['egn']);
    if ($ownerDeleted) {
        echo json_encode(["Result" => "Owner successfully deleted."]);
    }
    else {
        echo json_encode(["Result" => "An error occurred, please try again later."]);
    }
}
else {
    echo json_encode(["Result" => "You can't leave empty fields!"]);
}