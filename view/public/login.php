<?php
    $topHeading = "Vehicle Information Service";
    $pageName = "Log In";
    require_once ("../components/headerOnLoginValues.php");
    require_once ("../components/header.php");
?>
<form method="post" action="../../controller/loginController.php">
    <div class="w3-margin-top w3-margin-bottom" align="center">
        <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:50%">
            <br><br><br><br>
            <div align="center">
                <input class="w3-input w3-center" name='Username' type="text" required style="width:200px">
                <label class="w3-label w3-validate">Username</label>
            </div>
            <br>
            <div align="center">
                <input class="w3-input w3-center" name='Password' type="password" required style="width:200px">
                <label class="w3-label w3-validate">Password</label>
            </div>
            <br>
            <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Login">
        </div>
    </div>
</form>

<?php
    include_once ("../components/footer.php");
?>