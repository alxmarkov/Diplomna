<?php
session_start();
if (isset($_POST['button']) && isset($_SESSION['logTablePointer'])) {
    echo $_POST['button'] . " " . $_SESSION['logTablePointer'];
    switch ($_POST['button']) {
        case "Previous" : {
            $_SESSION['logTablePointer'] -= 10;
            break;
        }
        case "Next" : {
            $_SESSION['logTablePointer'] += 10;
            break;
        }
    }
}
echo $_SESSION['logTablePointer'];
header("Location: ../?");