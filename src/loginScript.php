<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <?php
            $enteredUsername = $_POST['Username'];
            $enteredPassword = $_POST['Password'];
            $errorMessage = "";

            $servername = "localhost";
            $username = "root";
            $dbname = "vis_database";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = $conn->prepare("SELECT Username, Password, Role, Active FROM logins WHERE Username = ?");
                $sql -> bindParam(1, $enteredUsername);
                $sql->execute();
                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) != 0) {
                    $loggingUser = $result[0]["Username"];
                    $currentDate = date("Y-m-d h:i:sa");
                    if (password_verify($enteredPassword, $result[0]["Password"])) {
                        if($result[0]["Active"] == "YES") {
                            session_start();
                            $_SESSION["username"] = $loggingUser;
                            $_SESSION["role"] = $result[0]["Role"];
                            $sqlLog = "INSERT INTO log (DateTimes, Usernames, Actions) VALUES ('$currentDate', '$loggingUser' , 'Logged In Successfully')";
                            $conn->exec($sqlLog);
                        }
                        else {
                            $errorMessage = "Your account is blocked!";
                            $sqlLog = "INSERT INTO log (DateTimes, Usernames, Actions) VALUES ('$currentDate', '$loggingUser' , 'Failed login: Blocked Account')";
                            $conn->exec($sqlLog);
                        }
                    }
                    else {
                        $errorMessage = "The entered password is incorrect!";
                        $sqlLog = "INSERT INTO log (DateTimes, Usernames, Actions) VALUES ('$currentDate', '$loggingUser' , 'Failed login: Wrong Password')";
                        $conn->exec($sqlLog);
                    }
                }
                else {
                    $errorMessage = "Wrong Username!";
                }

            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;

            if($errorMessage === "") {
                header("Location: ?");
            }
            else {
                echo "<p style='font-weight: 600'>" . $errorMessage . "</p>";
            }
        ?>
        <form method="post" action="">
            <input type="hidden" name="page" value="login">
            <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="Go Back">
        </form>
    </div>
</div>
