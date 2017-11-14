<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <?php
            use model\database\UserDao;
            session_start();
            function __autoload($className) {
                $className = str_replace("\\", "/", $className);
                require_once "../" . $className . '.php';
            }

            if (isset($_POST['Username']) && isset($_POST['Password'])) {
                $enteredUsername = $_POST['Username'];
                $enteredPassword = $_POST['Password'];
                $errorMessage = "";
                $userDao = UserDao::getInstance();
                $user = $userDao->userLogin($enteredUsername, $enteredPassword);
                var_dump($user);
                if ($user) {
                    $_SESSION["user"] = $user;
                    header("Location: ../index.php");
                } else {
                    echo "<p style='font-weight: 600'>Invalid Login!</p>";
                }
            }
            else {
                $passErrorMessage = "You can't leave empty fields!";
            }

        ?>
        <a href="../view/public/login.php"><button class='w3-btn w3-dark-grey w3-hover-light-grey'>Go Back</button></a>
    </div>
</div>
