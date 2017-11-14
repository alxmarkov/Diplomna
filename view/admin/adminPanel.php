<?php
    use model\database\AdminDao;
    use model\database\UserDao;
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
    $userDao = UserDao::getInstance();
    $lastAddedUsers = $userDao->getLastAddedUsers();
    $lastLogEntries = $adminDao->getLastFiveLogEntries();
?>

<div class="w3-margin-top w3-margin-bottom" align="center">

    <div class="w3-card-2 w3-padding-top w3-padding-bottom" style="min-height:360px;width:80%">
        <h4>Select action from the buttons below:</h4>
        <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="addUser()">Add User</button>
        <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="deActUser()">Deactivate User</button>
        <button class="w3-btn w3-dark-grey w3-hover-light-grey" onclick="actUser()">Activate User</button>

        <form id="addUser" class="w3-margin-top w3-margin-bottom" style="display:none" method="post" action="../../controller/addUserController.php">
            <table style="width:80%">
                <tr>
                    <td>
                        <div align="center">
                            <input class="w3-input w3-center" name='Username' type="text" required style="width:200px">
                            <label class="w3-label w3-validate">Username</label>
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <input class="w3-input w3-center" name='Password' type="password" required style="width:200px">
                            <label class="w3-label w3-validate">Password</label>
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <input class="w3-input w3-center" name='ConfirmPassword' type="password" required style="width:200px">
                            <label class="w3-label w3-validate">Confirm Password</label>
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <select name="Role">
                                <option value="select">Select</option>
                                <option value="administrator">Administrator</option>
                                <option value="vehiclemanager">Vehicle Manager</option>
                                <option value="insurarncemanager">Insurance Manager</option>
                                <option value="motmanager">MOT Manager</option>
                                <option value="taxmanager">Tax Manager</option>
                                <option value="investigator">Investigator</option>
                            </select>
                            <br>
                            <label class="w3-label">Role</label>
                        </div>
                    </td>
                    <td>
                        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Add">
                    </td>
                </tr>
            </table>
        </form>

        <form id="deActUser" class="w3-margin-top w3-margin-bottom" style="display:none" method="post" action="../../controller/changeUserActiveController.php">
            <input type="hidden" name="action" value="deactUser">
            <table style="width:30%">
                <tr>
                    <td>
                        <div align="center">
                            <input class="w3-input w3-center" name='Username' type="text" required style="width:200px">
                            <label class="w3-label w3-validate">Username</label>
                        </div>
                    </td>
                    <td>
                        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Deactivate">
                    </td>
                </tr>
            </table>
        </form>

        <form id="actUser" class="w3-margin-top w3-margin-bottom" style="display:none" method="post" action="../../controller/changeUserActiveController.php">
            <input type="hidden" name="action" value="actUser">
            <table style="width:30%">
                <tr>
                    <td>
                        <div align="center">
                            <input class="w3-input w3-center" name='Username' type="text" required style="width:200px">
                            <label class="w3-label w3-validate">Username</label>
                        </div>
                    </td>
                    <td>
                        <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Activate">
                    </td>
                </tr>
            </table>
        </form>

        <h4>Newest Users:</h4>
        <div class="w3-responsive w3-card-4 w3-margin-top w3-margin-bottom" style="width:35%">
            <table class="w3-table w3-striped w3-bordered">
                <?php
                    if (isset($lastAddedUsers[0])) {
                        echo "<tr>";
                        foreach ($lastAddedUsers[0] as $key => $value) {
                            echo "<th class=\"w3-theme\">" . $key . "</th>";
                        }
                        echo "</tr>";
                        for($i = 0; $i < count($lastAddedUsers); $i++) {
                            echo "<tr>";
                            foreach ($lastAddedUsers[$i] as $key => $value) {
                                echo "<td>" . $value . "</td>";
                            }
                            echo "</tr>";
                        }
                    }

                ?>
            </table>
        </div>

        <h4>Latest updates on the database:</h4>
        <div class="w3-responsive w3-card-4 w3-margin-top w3-margin-bottom" style="width:90%">
            <table class="w3-table w3-striped w3-bordered">
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

        <form method="post" action="adminPanelLog.php">
            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="View Full Log">
        </form>
    </div>

</div>

<script type="text/javascript">
    function addUser() {
        var au = document.getElementById('addUser');
        var du = document.getElementById('deActUser');
        var actu = document.getElementById('actUser');
        if (au.style.display !== 'none') {
            au.style.display = 'none';
        }
        else {
            if(du.style.display !== 'none' || actu.style.display !== 'none'){
                au.style.display = 'block';
                du.style.display = 'none';
                actu.style.display = 'none';
            }
            else {
                au.style.display = 'block';
            }
        }
    }
    function deActUser() {
        var du = document.getElementById('deActUser');
        var au = document.getElementById('addUser');
        var actu = document.getElementById('actUser');
        if (du.style.display !== 'none') {
            du.style.display = 'none';
        }
        else {
            if(au.style.display !== 'none' || actu.style.display !== 'none'){
                du.style.display = 'block';
                au.style.display = 'none';
                actu.style.display = 'none';
            }
            else {
                du.style.display = 'block';
            }
        }
    }
    function actUser() {
        var du = document.getElementById('deActUser');
        var au = document.getElementById('addUser');
        var actu = document.getElementById('actUser');
        if (actu.style.display !== 'none') {
            actu.style.display = 'none';
        }
        else {
            if(au.style.display !== 'none' || du.style.display !== 'none'){
                actu.style.display = 'block';
                au.style.display = 'none';
                du.style.display = 'none';
            }
            else {
                actu.style.display = 'block';
            }
        }
    }
</script>

<?php
    include_once ("../components/footer.php");
?>