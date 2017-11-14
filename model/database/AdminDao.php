<?php

namespace model\database;

use PDO;
use PDOException;

class AdminDao
{

    private static $instance;
    private $pdo;

    const GET_LOG = "SELECT * 
                      FROM log 
                      ORDER BY ID DESC 
                      LIMIT 10";

    const GET_LOG_OFFSET = "SELECT * 
                            FROM log 
                            ORDER BY ID DESC 
                            LIMIT ?, 10";


    const GET_LATEST_LOG = "SELECT * 
                            FROM log 
                            ORDER BY ID DESC 
                            LIMIT 5";

    private function __construct()
    {
        $this->pdo = DBManager::getInstance()->dbConnect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new AdminDao();
        }
        return self::$instance;
    }

    function getLogPage($offset = 0)
    {
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        if ($offset == 0) {
            $statement = $this->pdo->prepare(self::GET_LOG);
            $statement->execute();
        } else {
            $statement = $this->pdo->prepare(self::GET_LOG_OFFSET);
            $statement->execute(array($offset));
        }
        $logPage = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $logPage;

    }

    function getLastFiveLogEntries()
    {
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $statement = $this->pdo->prepare(self::GET_LATEST_LOG);
        $statement->execute();
        $log = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $log;

    }
}