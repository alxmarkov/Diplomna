<?php
use model\classes\Vehicle;

use model\database\VehicleDao;
use model\database\OwnerDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
session_start();

$message = "";

if(isset($_POST['editVin']) &&
    trim($_POST['editVin']) != "" &&
    isset($_POST['editNumberplate']) &&
    trim($_POST['editNumberplate']) != "" &&
    isset($_POST['editType']) &&
    trim($_POST['editType']) != "" &&
    isset($_POST['editMake']) &&
    trim($_POST['editMake']) != "" &&
    isset($_POST['editModel']) &&
    trim($_POST['editModel']) != "" &&
    isset($_POST['editEngineType']) &&
    trim($_POST['editEngineType']) != "" &&
    isset($_POST['editEngineSize']) &&
    trim($_POST['editEngineSize']) != "" &&
    isset($_POST['editYear']) &&
    trim($_POST['editYear']) != "" &&
    isset($_POST['editColor']) &&
    trim($_POST['editColor']) != "" &&
    isset($_POST['editOwnerID']) &&
    trim($_POST['editOwnerID']) != "") {

    $editedVehicle = new Vehicle();
    $editedVehicle->setVIN(htmlspecialchars(strtoupper($_POST['editVin'])));
    $editedVehicle->setNumberPlate(htmlspecialchars(strtoupper($_POST['editNumberplate'])));
    $editedVehicle->setType(htmlspecialchars(ucfirst($_POST['editType'])));
    $editedVehicle->setMake(htmlspecialchars(ucfirst($_POST['editMake'])));
    $editedVehicle->setModel(htmlspecialchars(ucfirst($_POST['editModel'])));
    $editedVehicle->setEngineType(htmlspecialchars(ucfirst($_POST['editEngineType'])));
    $editedVehicle->setEngineSize(htmlspecialchars($_POST['editEngineSize']));
    $editedVehicle->setYearOfMfg(htmlspecialchars($_POST['editYear']));
    $editedVehicle->setColor(htmlspecialchars(ucfirst($_POST['editColor'])));
    $ownerDao = OwnerDao::getInstance();
    $ownerId = $ownerDao->getIdByEGN(htmlspecialchars($_POST['editOwnerID']));
    $editedVehicle->setOwnerID($ownerId);

    $tmpFileName = $_FILES['editPicture']['tmp_name'];
    if ($tmpFileName != "") {
        if (is_uploaded_file($tmpFileName)) {
            $vehicleID = $editedVehicle->getVIN();
            $uploadedFileName = $_FILES['editPicture']['name'];
            $filePath = "uploads/$vehicleID/vehicle/vehPicture." . pathinfo($_FILES['editPicture']['name'], PATHINFO_EXTENSION);
            $editedVehicle->setPicturePath($filePath);
            unlink("../$filePath");
            move_uploaded_file($tmpFileName, "../$filePath");
        } else {
            $message = "There was an error uploading the picture. Please make sure that it is in a valid format.";
        }
    }
}
else {
    $message = "You can't leave empty fields!";
}

if ($message == "") {
    $vehicleDao = VehicleDao::getInstance();
    $addSuccess = $vehicleDao->updateVehicle($editedVehicle);
    if(!$addSuccess) {
        $message = "An error occurred, please try again later.";
    }
    else {
        $message = "Vehicle successfully edited.";
    }
}

$topHeading = "Vehicle Information Service";
$pageName = "Vehicle Management Panel";
require_once ("../view/components/headerLoggedInValues.php");
require_once ("../view/components/header.php");
?>
    <div class="w3-margin-top" align="center">
        <div class="w3-card-2 w3-padding-top w3-margin" style="min-height:360px;width:80%">
            <h4><?=$message?></h4>
            <a href="../view/vehicle/vehMgmtPanel.php"><button class="w3-btn w3-dark-grey w3-hover-light-grey w3-margin">To Management Panel</button></a>
        </div>
    </div>

<?php
require_once ("../view/components/footer.php");
?>