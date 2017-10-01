<?php
session_start();
$currentDate = date("Y-m-d h:i:sa");
$loggingUser = $_SESSION["username"];

session_unset();
session_destroy();

$servername = "localhost";
$username = "root";
$dbname = "vis_database";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlLog = "INSERT INTO log (DateTimes, Usernames, Actions) VALUES ('$currentDate', '$loggingUser' , 'Logged Out')";
    $conn->exec($sqlLog);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

header("Location: ../");