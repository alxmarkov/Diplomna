<div class="w3-margin-top w3-margin-bottom" align="center">
    <div class="w3-card-2 w3-padding-top" style="min-height:360px;width:80%">

<!--        <p>This table is the result of the search of the database with the provided Number Plate. If it is empty, there were no matches.</p>-->
        <?php
            if(isset($_POST['captchapass']) && isset($_POST['numberplate'])) {
                if($_POST['captchapass'] == $_SESSION['captcha']['code']) {
                    //sql query and data validation here
                    echo "<p>The received number plate is " . $_POST['numberplate'] . " and the captcha is : " . $_POST['captchapass'] . ".</p>";
                }
                else {
                    echo "<p>The entered captcha code is not valid!</p><br>";
                    echo "<a href='?page=home' class='w3-btn w3-dark-grey w3-hover-light-grey' >To Homepage</a>";
                }
            }
            else {
                    echo "<p>This operation is not valid!</p><br>";
            }
        ?>
    </div>
</div>