<?php
use model\database\AdminDao;
function __autoload($className) {
    $className = str_replace("\\", "/", $className);
    require_once "../" . $className . '.php';
}
if (isset($_GET['logID'])) {
    $offset = $_GET['logID'];
}
else {
    $offset = 0;
}
$adminDao = AdminDao::getInstance();
$logPage = $adminDao->getLogPage($offset);
if ($logPage) {
    header('Content-Type: application/json');
    echo json_encode($logPage);
}