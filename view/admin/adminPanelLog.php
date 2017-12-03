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
<script src="../../assets/js/adminLog.js"></script>
<?php
    include_once ("../components/footer.php");
?>