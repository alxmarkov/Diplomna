<?php
if (isset($_GET['logID'])) {
    $low = $_GET['logID'];
    $servername = "localhost";
    $username = "root";
    $dbname = "vis_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlLog = $conn->prepare("SELECT * FROM log ORDER BY ID DESC LIMIT $low, 10");
        $sqlLog->execute();
        $resultLog = $sqlLog->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($resultLog);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
}