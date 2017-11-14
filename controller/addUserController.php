<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">

        <?php

        use model\database\UserDao;
        use model\classes\User;
        function __autoload($className) {
            $className = str_replace("\\", "/", $className);
            require_once "../" . $className . '.php';
        }

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


        if ($passErrorMessage == "" && $roleErrorMessage == "") {
            $userDao = UserDao::getInstance();
            $user = new User(null, $newUser, $newPass, $newRole, null, null);
            $userDao->addUser($user);
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