<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <?php
        $errorMessage = "";

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
            $servername = "localhost";
            $dbUsername = "root";
            $dbName = "vis_database";
            $nameOfAdmin = $_SESSION['username'];
            $currentDate = date("Y-m-d h:i:sa");
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbName", $dbUsername);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //                echo "<p>Connected successfully<br></p>";
                $sql = "UPDATE logins SET Active='$userActive' WHERE Username='$manipulatedUser'";
                $conn->exec($sql);
                echo "<p style='font-weight: 600'>User " . $manipulatedUser . " " . $resultMessage . "!<br></p>";
                $sqlLog = "INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES ('$currentDate', '$nameOfAdmin' , '$logMessage', '$manipulatedUser', 'logins')";
                $conn->exec($sqlLog);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            $conn = null;
        }
        ?>
        <form method="post" action="">
            <input type="hidden" name="page" value="adminPanel">
            <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="To Admin Panel">
        </form>
    </div>
</div>
