<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageName ?></title>
    <link rel="icon" href="./assets/images/favicon.ico">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-teal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">

</head>

<body>

<header class="w3-container w3-theme w3-padding" id="myHeader">
    <div class="w3-right">
        <form method="post" action="<?= $loginButtonAction?>">
            <input type="hidden" name="page" value="login">
            <?= $greeting?>
            <input class="w3-btn w3-dark-grey w3-hover-light-grey <?= $loginButtonDisabled?>" type="<?= $loginButtonType?>" value="<?= $loginButtonText ?>">
        </form>
    </div>
    <br><br>
    <div class="w3-center">
        <h4><?= $topHeading?></h4>
        <h1 class="w3-xxxlarge w3-animate-bottom"><?= $pageName?></h1>
    </div>
</header>