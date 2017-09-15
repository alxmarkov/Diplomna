<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">

        <?php

        //$password = "mypassword";
        //$secondPassword = "titiegiggles";
        //echo $password . "\n";
        //$hash = password_hash($password, PASSWORD_DEFAULT);
        //echo $hash . "\n";
        //
        //if (password_verify($secondPassword, $hash)) {
        //    echo "The passwords match!\n";
        //}
        //else {
        //    echo "The passwords don't match!\n";
        //}

        $passErrorMessage = "";
        $roleErrorMessage = "";

        if(isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['ConfirmPassword']) && isset($_POST['Role'])) {
            $newUser = $_POST['Username'];
            $newPass = $_POST['Password'];
            $confirmNewPass = $_POST['ConfirmPassword'];
            $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);
            $newRole = $_POST['Role'];
            $newActive = "YES";
            $dateAdded = date("Y-m-d h:i:sa");
            if($newPass !== $confirmNewPass) {
                $passErrorMessage = "The entered passwords do not match!";
            }

            switch ($newRole) {
                case "administrator" : {
                    $newRole = 11;
                    break;
                }
                case "vehiclemanager" : {
                    $newRole = 22;
                    break;
                }
                case "insurarncemanager" : {
                    $newRole = 33;
                    break;
                }
                case "motmanager" : {
                    $newRole = 44;
                    break;
                }
                case "taxmanager" : {
                    $newRole = 55;
                    break;
                }
                case "investigator" : {
                    $newRole = 66;
                    break;
                }
                default : {
                    $roleErrorMessage = "Please enter a valid user role!";
                    break;
                }
            }
        }
        else {
            $passErrorMessage = "You can't leave empty fields!";
        }


//        echo $user . "<br>" . $pass . "<br>" .$confirmPass . "<br>" . $role . "<br>" . $roleErrorMessage . "<br>" . $passErrorMessage . "<br>" . "END";

        if ($passErrorMessage == "" && $roleErrorMessage == "") {
            $serverName = "localhost";
            $dbUsername = "root";
            $dbName = "vis_database";
            $nameOfAdmin = $_SESSION['username'];
            $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername);
            try {
                $conn->beginTransaction();
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO logins (Username, Password, Role, Active, DateAdded) VALUES ('$newUser', '$newPassHash', '$newRole', '$newActive', '$dateAdded')";
                $conn->exec($sql);
                echo "<p style='font-weight: 600'>New user " . $newUser . " added succesfully!<br></p>";
                $sqlLog = "INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES ('$dateAdded', '$nameOfAdmin' , 'Added User', '$newUser', 'logins')";
                $conn->exec($sqlLog);
                $conn->commit();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo "Connection failed: " . $e->getMessage();
            }
            $conn = null;
        }
        else {
            echo "<p style='font-weight: 600'>" . $passErrorMessage . $roleErrorMessage . "</p>";
        }
//        ?>

        <form method="post" action="">
            <input type="hidden" name="page" value="adminPanel">
            <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="To Admin Panel">
        </form>
    </div>
</div>