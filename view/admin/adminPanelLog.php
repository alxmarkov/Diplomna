<?php
    use model\database\AdminDao;
    function __autoload($className) {
        $className = str_replace("\\", "/", $className);
        require_once "../../" . $className . '.php';
    }
    session_start();

    $topHeading = "Vehicle Information Service";
    $pageName = "Administration Panel";
    require_once ("../components/headerLoggedInValues.php");
    require_once ("../components/header.php");
    $adminDao = AdminDao::getInstance();
    $lastLogEntries = $adminDao->getLogPage();
?>

<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">
        <h4>Full System Log:</h4>
        <div class="w3-responsive w3-card-4 w3-margin-top w3-margin-bottom" style="width:90%">
            <table id="logTable" class="w3-table w3-striped w3-bordered">
                <?php
                if (isset($lastLogEntries[0])) {
                    echo "<tr>";
                    foreach ($lastLogEntries[0] as $key => $value) {
                        echo "<th class=\"w3-theme\">" . $key . "</th>";
                    }
                    echo "</tr>";
                    for($i = 0; $i < count($lastLogEntries); $i++) {
                        echo "<tr>";
                        foreach ($lastLogEntries[$i] as $key => $value) {
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
            <form method="post" action="adminPanel.php">
                <input class='w3-btn w3-dark-grey w3-hover-light-grey' type="submit" value="Go Back">
            </form>
        </div>
        <input type="hidden" id="logNumber" value="<?= 0?>">
        <input type="hidden" id="maxLogNumber" value="<?= $lastLogEntries[0]["ID"]?>">
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
            xmlhttp.open("GET", "../../controller/changeLogPageController.php?logID="+logID);
            xmlhttp.send();
        }
    }

</script>
<?php
    include_once ("../components/footer.php");
?>