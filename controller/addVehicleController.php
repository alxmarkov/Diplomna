<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">

        <?php
        session_start();
        require_once "../model/classes/Vehicle.php";
        require_once "../model/classes/Owner.php";
        require_once "../model/database/vehicles_sql_queries.php";

        $errorMessage = "";


        if(isset($_POST['vin']) && isset($_POST['numberplate']) && isset($_POST['make']) && isset($_POST['model']) && isset($_POST['engineSize']) && isset($_POST['year']) && isset($_POST['color']) && isset($_POST['ownerID'])  && isset($_POST['ownerCity']) && isset($_POST['ownerName']) && isset($_POST['ownerFName']) && isset($_POST['ownerAddress'])) {
            $newVehicle = new Vehicle();
            $newVehicle->setVIN(htmlspecialchars(strtoupper($_POST['vin'])));
            $newVehicle->setNumberPlate(htmlspecialchars(strtoupper($_POST['numberplate'])));
            $newVehicle->setMake(htmlspecialchars(ucfirst($_POST['make'])));
            $newVehicle->setModel(htmlspecialchars(ucfirst($_POST['model'])));
            $newVehicle->setEngineType(htmlspecialchars(ucfirst($_POST['engineType'])));
            $newVehicle->setEngineSize(htmlspecialchars($_POST['engineSize']));
            $newVehicle->setYearOfMfg(htmlspecialchars($_POST['year']));
            $newVehicle->setColor(htmlspecialchars(ucfirst($_POST['color'])));
            $newVehicle->setOwnerID(htmlspecialchars($_POST['ownerID']));

            $newOwner = new Owner();
            $newOwner->setID(htmlspecialchars($_POST['ownerID']));
            $newOwner->setCity(htmlspecialchars(ucfirst($_POST['ownerCity'])));
            $newOwner->setName(htmlspecialchars(ucfirst($_POST['ownerName'])));
            $newOwner->setFamilyName(htmlspecialchars(ucfirst($_POST['ownerFName'])));
            $newOwner->setAddress(htmlspecialchars(ucwords($_POST['ownerAddress'])));

            $dateAdded = date("Y-m-d h:i:sa");
            $nameOfManager = $_SESSION['username'];

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
            if(!addOwner($newOwner) || !addVehicle($newVehicle)) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                    rmdir("uploads/$newVehicle[0]/vehicle");
                    rmdir("uploads/$newVehicle[0]");
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