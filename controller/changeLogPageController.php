<?php
require_once "../model/database/admin_sql_queries.php";
if (isset($_GET['logID'])) {
    $offset = $_GET['logID'];
}
else {
    $offset = 0;
}
$logPage = getLogPage($offset);
if ($logPage) {
    header('Content-Type: application/json');
    echo json_encode($logPage);
}