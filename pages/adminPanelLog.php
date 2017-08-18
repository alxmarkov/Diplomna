<?php
    $servername = "localhost";
    $username = "root";
    $dbname = "vis_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isset($_SESSION['logTablePointer'])) {
            $logTablePointer = $_SESSION['logTablePointer'];
        }
        else {
            $logTablePointer = 0;
            $_SESSION['logTablePointer'] = 0;
        }
        $sqlLog = $conn->prepare("SELECT * FROM log ORDER BY ID DESC LIMIT $logTablePointer, 10");
        $sqlLog->execute();
        $resultLog = $sqlLog->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
?>

<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">

        <div class="w3-responsive w3-card-4 w3-margin-top w3-margin-bottom" style="width:90%">
            <table class="w3-table w3-striped w3-bordered">
                <?php
                if (isset($resultLog[0])) {
                    echo "<tr>";
                    foreach ($resultLog[0] as $key => $value) {
                        echo "<th class=\"w3-theme\">" . $key . "</th>";
                    }
                    echo "</tr>";
                    for($i = 0; $i < count($resultLog); $i++) {
                        echo "<tr>";
                        foreach ($resultLog[$i] as $key => $value) {
                            echo "<td>" . $value . "</td>";
                        }
                        echo "</tr>";
                    }
                }

                ?>
            </table>
        </div>
        <div class="w3-responsive  w3-margin-top w3-margin-bottom" style="width:90%; display: inline-block">
            <form class="w3-left" method="post" action="./src/changeLogPage.php">
                <input type="hidden" name="button" value="Previous">
                <input class='w3-btn w3-dark-grey w3-hover-light-grey' style="width: 100px" type="submit" value="Previous">
            </form>
            <form class="w3-right" method="post" action="./src/changeLogPage.php">
                <input type="hidden" name="button" value="Next">
                <input class='w3-btn w3-dark-grey w3-hover-light-grey' style="width: 100px" type="submit" value="Next">
            </form>
            <form method="post" action="">
                <input type="hidden" name="page" value="adminPanel">
                <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="Go Back">
            </form>
        </div>
    </div>
</div>