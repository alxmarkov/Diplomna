<?php
    include("./assets/captcha/simple-php-captcha.php");
    $_SESSION['captcha'] = simple_php_captcha();
?>

<div class="w3-row-padding w3-center w3-margin-top">
    <div class="w3-half">
        <div class="w3-card-2 w3-padding-top" style="min-height:360px">
            <h4>Instructions</h4><br>
            <i class="fa fa-desktop w3-margin-bottom w3-text-theme" style="font-size:120px"></i>
            <p>Enter the vehicle number plate number in the top field.</p>
            <p>Enter the confirmation code from the picture in the bottom field.<br>
                To hear the spelling of the code, press the link below the picture.
            </p>
            <p>Press the Submit button.</p>
        </div>
    </div>

    <form method="post" action="">
        <input type="hidden" name="page" value="publicSearch">
        <div class="w3-half">
            <div class="w3-card-2 w3-padding-top" style="min-height:360px">

                <div align="center">
                    <input class="w3-input w3-center" name='numberplate' type="text" required style="text-transform:uppercase;width:120px" maxlength="8">
                    <label class="w3-label w3-validate">Number Plate Number</label>
                </div>
                <br>
                <div align="center">
                    <input class="w3-input w3-center" name='captchapass' type="text" required style="width:120px">
                    <label class="w3-label w3-validate">Confirmation Code</label>
                </div>
                <br>
                <img src="<?= $_SESSION['captcha']['image_src']?>" alt="Captcha Image"><br>
                <br>
                <input class="w3-btn w3-dark-grey w3-hover-light-grey" type="submit" value="Submit">
            </div>
        </div>
    </form>

</div>