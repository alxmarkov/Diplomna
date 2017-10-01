<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <?php
            session_start();
            require_once "../model/database/admin_sql_queries.php";
            if (isset($_POST['Username']) && isset($_POST['Password'])) {
                $enteredUsername = $_POST['Username'];
                $enteredPassword = $_POST['Password'];
                $errorMessage = "";


                if ($user = userLogin($enteredUsername, $enteredPassword)) {
                    $_SESSION["username"] = $user["Username"];
                    $_SESSION["role"] = $user["Role"];

                    echo  $_SESSION["username"];
                    echo " " . $_SESSION["role"];
                    header("Location: ../index.php");
                } else {
                    echo "<p style='font-weight: 600'>Invalid Login!</p>";
                }
            }
            else {
                $passErrorMessage = "You can't leave empty fields!";
            }

        ?>
        <form method="post" action="">
            <input type="hidden" name="page" value="login">
            <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="Go Back">
        </form>
    </div>
</div>
