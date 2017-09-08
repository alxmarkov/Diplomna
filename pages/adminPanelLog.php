<?php
    $servername = "localhost";
    $username = "root";
    $dbname = "vis_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlLog = $conn->prepare("SELECT * FROM log ORDER BY ID DESC LIMIT 10");
        $sqlLog->execute();
        $resultLog = $sqlLog->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
?>

<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <h4>Full System Log:</h4>
        <div class="w3-responsive w3-card-4 w3-margin-top w3-margin-bottom" style="width:90%">
            <table id="logTable" class="w3-table w3-striped w3-bordered">
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
            <button class='w3-btn w3-dark-grey w3-hover-light-grey' style="width: 100px; float: left" onclick="changePage('previous')">Previous</button>
            <button class='w3-btn w3-dark-grey w3-hover-light-grey' style="width: 100px; float: right" onclick="changePage('next')">Next</button>
            <form method="post" action="">
                <input type="hidden" name="page" value="adminPanel">
                <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="Go Back">
            </form>
        </div>
        <input type="hidden" id="logNumber" value="<?= 0?>">
        <input type="hidden" id="maxLogNumber" value="<?= $resultLog[0]["ID"]?>">
    </div>
</div>

<script>
    function changePage(direction) {
        var logID = parseInt(document.getElementById('logNumber').value);
        var change = true;
        if (direction === "previous") {
            logID -= 10;
            if (logID < 0) {
                logID = 0;
                document.getElementById('logNumber').value = "0";
                change = false;
            }
            else {
                document.getElementById('logNumber').value = logID.toString();
            }
        }
        else if (direction === "next") {
            logID += 10;
            if (logID > parseInt(document.getElementById('maxLogNumber').value)) {
                logID -= 10;
                change = false;
            }
            document.getElementById('logNumber').value = logID.toString();
        }
        if (change) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.status === 200) {
                    var result = JSON.parse(this.responseText);
                    var tableContent = "";
                    for (var i = 0; i < result.length; i++) {
                        if (i === 0) {
                            tableContent += "<tr>";
                            for (var heading in result[0]) {
                                tableContent += "<th class='w3-theme'>" + heading + "</th>";
                            }
                            tableContent += "</tr>";
                        }
                        tableContent += "<tr>";
                        for (var key in result[i]) {
                            if (result[i][key] !== null) {
                                tableContent += "<td>" + result[i][key] + "</td>";
                            }
                            else {
                                tableContent += "<td></td>";
                            }
                        }
                        tableContent += "</tr>";
                    }
                    document.getElementById('logTable').innerHTML = tableContent;
                }
            };
            xmlhttp.open("GET", "./src/changeLogPage.php?logID="+logID);
            xmlhttp.send();
        }
    }

</script>