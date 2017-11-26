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


if(isset($_POST['vin']) &&
    trim($_POST['vin']) != "" &&
    isset($_POST['numberplate']) &&
    trim($_POST['numberplate']) != "" &&
    isset($_POST['type']) &&
    trim($_POST['type']) != "" &&
    isset($_POST['make']) &&
    trim($_POST['make']) != "" &&
    isset($_POST['model']) &&
    trim($_POST['model']) != "" &&
    isset($_POST['engineType']) &&
    trim($_POST['engineType']) != "" &&
    isset($_POST['engineSize']) &&
    trim($_POST['engineSize']) != "" &&
    isset($_POST['year']) &&
    trim($_POST['year']) != "" &&
    isset($_POST['color']) &&
    trim($_POST['color']) != "" &&
    isset($_POST['ownerID']) &&
    trim($_POST['ownerID']) != "") {

    $newVehicle = new Vehicle();
    $newVehicle->setVIN(htmlspecialchars(strtoupper($_POST['vin'])));
    $newVehicle->setNumberPlate(htmlspecialchars(strtoupper($_POST['numberplate'])));
    $newVehicle->setType(htmlspecialchars(ucfirst($_POST['type'])));
    $newVehicle->setMake(htmlspecialchars(ucfirst($_POST['make'])));
    $newVehicle->setModel(htmlspecialchars(ucfirst($_POST['model'])));
    $newVehicle->setEngineType(htmlspecialchars(ucfirst($_POST['engineType'])));
    $newVehicle->setEngineSize(htmlspecialchars($_POST['engineSize']));
    $newVehicle->setYearOfMfg(htmlspecialchars($_POST['year']));
    $newVehicle->setColor(htmlspecialchars(ucfirst($_POST['color'])));
    $ownerDao = OwnerDao::getInstance();
    $ownerId = $ownerDao->getIdByEGN(htmlspecialchars($_POST['ownerID']));
    $newVehicle->setOwnerID($ownerId);

    $tmpFileName = $_FILES['picture']['tmp_name'];
    if (is_uploaded_file($tmpFileName)) {
        $vehicleID = $newVehicle->getVIN();
        $uploadedFileName = $_FILES['picture']['name'];
        $filePath = "uploads/$vehicleID/vehicle/vehPicture." . pathinfo($_FILES['picture']['name'],PATHINFO_EXTENSION);
        $newVehicle->setPicturePath($filePath);
        mkdir("../uploads/$vehicleID", 0777);
        mkdir("../uploads/$vehicleID/vehicle", 0777);
        move_uploaded_file($tmpFileName, "../$filePath");
    }
    else {
        $message = "There was an error uploading the picture. Please make sure that it is in a valid format.";
    }
}
else {
    $message = "You can't leave empty fields!";
}

if ($message == "") {
    $vehicleDao = VehicleDao::getInstance();
    $addSuccess = $vehicleDao->addVehicle($newVehicle);
    if(!$addSuccess) {
        if (file_exists("../" . $filePath)) {
            unlink("../" . $filePath);
            $vin = $newVehicle->getVIN();
            rmdir("../uploads/$vin/vehicle");
            rmdir("../uploads/$vin");
        }
        $message = "An error occurred, please try again later.";
    }
    else {
        $message = "New vehicle successfully added";
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