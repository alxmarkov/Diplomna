<?php
use model\classes\Owner;
use model\database\OwnerDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
session_start();

if (isset($_POST['ownerID']) &&
    isset($_POST['ownerCity']) &&
    isset($_POST['ownerName']) &&
    isset($_POST['ownerFName']) &&
    isset($_POST['ownerAddress']) &&
    trim($_POST['ownerID']) != "" &&
    trim($_POST['ownerCity']) != "" &&
    trim($_POST['ownerName']) != "" &&
    trim($_POST['ownerFName']) != "" &&
    trim($_POST['ownerAddress']) != "") {

    $newOwner = new Owner();
    $newOwner->setEGN(htmlspecialchars($_POST['ownerID']));
    $newOwner->setCity(htmlspecialchars(ucfirst($_POST['ownerCity'])));
    $newOwner->setName(htmlspecialchars(ucfirst($_POST['ownerName'])));
    $newOwner->setFamilyName(htmlspecialchars(ucfirst($_POST['ownerFName'])));
    $newOwner->setAddress(htmlspecialchars(ucwords($_POST['ownerAddress'])));

    $ownerDao = OwnerDao::getInstance();
    $editSuccess = $ownerDao->updateOwner($newOwner);
    if($editSuccess) {
        echo json_encode(["Result" => "Owner info successfully updated!"]);
    }
    else {
        echo json_encode(["Result" => "An error occured, please try again later."]);
    }
}
else {
    echo json_encode(["Result" => "You can't leave empty fields!"]);
}