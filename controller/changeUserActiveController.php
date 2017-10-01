<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <?php
        session_start();
        $errorMessage = "";
        require_once "../model/database/admin_sql_queries.php";

        if (!isset($_POST['Username'])) {
            echo "<p style='font-weight: 600'>Please enter a valid Username!</p>";
        }
        elseif (!isset($_POST['action'])) {
            echo "<p style='font-weight: 600'>Invalid Action!</p>";
        }
        else {
            $manipulatedUser = $_POST['Username'];
            if($_POST['action'] == "actUser") {
                $userActive = "YES";
                $resultMessage = "activated successfully";
                $logMessage = "Activated User";
            }
            elseif ($_POST['action'] == "deactUser") {
                $userActive = "NO";
                $resultMessage = "deactivated successfully";
                $logMessage = "Deactivated User";
            }
            else {
                echo "<p style='font-weight: 600'>Invalid Action!</p>";
                exit();
            }
            changeUserActive($manipulatedUser, $userActive, $logMessage);
            header("Location: ../view/admin/adminPanel.php");
        }
        ?>
        <form method="post" action="">
            <input type="hidden" name="page" value="adminPanel">
            <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="To Admin Panel">
        </form>
    </div>
</div>
