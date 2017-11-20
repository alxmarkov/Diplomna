<?php

    use model\classes\Owner;
    use model\database\OwnerDao;
    function __autoload($className) {
        $className = str_replace("\\", "/", $className);
        require_once "../" . $className . '.php';
    }
    session_start();

    $errorMessage = "";

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
    }
    else {
        $errorMessage = "You can't leave empty fields!";
    }

    if ($errorMessage == "") {
        $ownerDao = OwnerDao::getInstance();
        $addSuccess = $ownerDao->addOwner($newOwner);
        if($addSuccess) {
            echo json_encode(["Result" => "New owner successfully added!"]);
        }
        else {
            echo json_encode(["Result" => "An error occured, please try again later."]);
        }
    }
    else {
        echo json_encode(["Result" => $errorMessage]);
    }