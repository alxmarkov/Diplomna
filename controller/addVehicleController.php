<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">

        <?php
        use model\classes\Vehicle;

        use model\database\VehicleDao;
        use model\database\OwnerDao;
        function __autoload($className) {
            $className = str_replace("\\", "/", $className);
            require_once "../" . $className . '.php';
        }
        session_start();

        $errorMessage = "";


        if(isset($_POST['vin']) && isset($_POST['numberplate']) && isset($_POST['type']) && isset($_POST['make']) && isset($_POST['model']) && isset($_POST['engineSize']) && isset($_POST['year']) && isset($_POST['color']) && isset($_POST['ownerID'])) {
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


            $dateAdded = date("Y-m-d h:i:sa");

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
                $errorMessage = "There was an error uploading the picture. Please make sure that it is in a valid format.";
            }
        }
        else {
            $errorMessage = "You can't leave empty fields!";
        }

        if ($errorMessage == "") {
            $vehicleDao = VehicleDao::getInstance();
            $addSuccess = $vehicleDao->addVehicle($newVehicle);
            if(!$addSuccess) {
                if (file_exists("../" . $filePath)) {
                    unlink("../" . $filePath);
                    $vin = $newVehicle->getVIN();
                    rmdir("../uploads/$vin/vehicle");
                    rmdir("../uploads/$vin");
                }
            }
        }
        else {
            echo "<p style='font-weight: 600'>" . $errorMessage . "</p>";
        }
        ?>

<form method="post" action="../src?">
    <input type="hidden" name="page" value="vehMgmtPanel">
    <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="To Vehicle Management Panel">
</form>
</div>
</div>