<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">

        <?php

        $errorMessage = "";


        if(isset($_POST['vin']) && isset($_POST['numberplate']) && isset($_POST['make']) && isset($_POST['model']) && isset($_POST['engineSize']) && isset($_POST['year']) && isset($_POST['color']) && isset($_POST['ownerID'])  && isset($_POST['ownerCity']) && isset($_POST['ownerName']) && isset($_POST['ownerFName']) && isset($_POST['ownerAddress'])) {
            $newVehicle = [];
            $newVehicle[] = htmlspecialchars(strtoupper($_POST['vin']));
            $newVehicle[] = htmlspecialchars(strtoupper($_POST['numberplate']));
            $newVehicle[] = htmlspecialchars(ucfirst($_POST['make']));
            $newVehicle[] = htmlspecialchars(ucfirst($_POST['model']));
            $newVehicle[] = htmlspecialchars(ucfirst($_POST['engineType']));
            $newVehicle[] = htmlspecialchars($_POST['engineSize']);
            $newVehicle[] = htmlspecialchars($_POST['year']);
            $newVehicle[] = htmlspecialchars(ucfirst($_POST['color']));

            $newOwner = [];
            $newOwner[] = htmlspecialchars($_POST['ownerID']);
            $newOwner[] = htmlspecialchars(ucfirst($_POST['ownerCity']));
            $newOwner[] = htmlspecialchars(ucfirst($_POST['ownerName']));
            $newOwner[] = htmlspecialchars(ucfirst($_POST['ownerFName']));
            $newOwner[] = htmlspecialchars(ucwords($_POST['ownerAddress']));

            $dateAdded = date("Y-m-d h:i:sa");
            $nameOfManager = $_SESSION['username'];

            $tmpFileName = $_FILES['picture']['tmp_name'];
            if (is_uploaded_file($tmpFileName)) {
                $uploadedFileName = $_FILES['picture']['name'];
                $filePath = "uploads/$newVehicle[0]/vehicle/vehPicture." . pathinfo($_FILES['picture']['name'],PATHINFO_EXTENSION);
                mkdir("uploads/$newVehicle[0]", 0777);
                mkdir("uploads/$newVehicle[0]/vehicle", 0777);
                move_uploaded_file($tmpFileName, "$filePath");
            }
            else {
                $errorMessage = "There was an error uploading the picture. Please make sure that it is in a valid format.";
            }
        }
        else {
            $errorMessage = "You can't leave empty fields!";
        }


        if ($errorMessage == "") {
            $serverName = "localhost";
            $dbUsername = "root";
            $dbName = "vis_database";
            $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {
                $conn->beginTransaction();

                $sqlOwner = "INSERT INTO owners (EGN, City, FirstName, FamilyName, Address) VALUES ('$newOwner[0]', '$newOwner[1]', '$newOwner[2]', '$newOwner[3]', '$newOwner[4]')";
                $conn->exec($sqlOwner);
                echo "<p style='font-weight: 600'>New owner " . $newOwner[0] . " added succesfully!<br></p>";

                $sqlLogOwner = "INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES ('$dateAdded', '$nameOfManager' , 'Added Owner', '$newOwner[0]', 'owners')";
                $conn->exec($sqlLogOwner);

                $sqlVeh = "INSERT INTO vehicles (VIN, Numberplate, Make, Model, EngineType, EngineSize, DateOfFirstRegistration, Color, PicturePath, OwnerID) VALUES ('$newVehicle[0]', '$newVehicle[1]', '$newVehicle[2]', '$newVehicle[3]', '$newVehicle[4]', '$newVehicle[5]', '$newVehicle[6]', '$newVehicle[7]', '$filePath', '$newOwner[0]')";
                $conn->exec($sqlVeh);
                echo "<p style='font-weight: 600'>New vehicle " . $newVehicle[0] . " added succesfully!<br></p>";

                $sqlLogVeh = "INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES ('$dateAdded', '$nameOfManager' , 'Added Vehicle', '$newVehicle[0]', 'vehicles')";
                $conn->exec($sqlLogVeh);

                $conn->commit();

            } catch (PDOException $e) {
                $conn->rollBack();
                echo "Connection failed: " . $e->getMessage();
                if (file_exists($filePath)) {
                    unlink($filePath);
                    rmdir("uploads/$newVehicle[0]/vehicle");
                    rmdir("uploads/$newVehicle[0]");
                }

            }
            $conn = null;
        }
        else {
            echo "<p style='font-weight: 600'>" . $errorMessage . "</p>";
        }
        ?>

<form method="post" action="./?">
    <input type="hidden" name="page" value="vehMgmtPanel">
    <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="To Vehicle Management Panel">
</form>
</div>
</div>