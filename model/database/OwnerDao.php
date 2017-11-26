<?php

namespace model\database;

use PDO;
use PDOException;
use model\classes\Owner;

class OwnerDao
{
    private static $instance;
    private $pdo;

    const ADD_LOG = "INSERT INTO log 
                      (DateTimes, Usernames, Actions, Records, Tables) 
                      VALUES 
                      (?, ?, ?, ?, ?)";

    const ADD_OWNER = "INSERT INTO owners 
                        (EGN, City, FirstName, FamilyName, Address) 
                        VALUES 
                        (?, ?, ?, ?, ?)";

    const GET_ID_BY_EGN = "SELECT
                            ID
                            FROM owners
                            WHERE EGN = ?";

    const GET_EGN_BY_ID = "SELECT
                            EGN
                            FROM owners
                            WHERE ID = ?";

    const GET_EGN_SUGGESTIONS = "SELECT
                                 EGN
                                 FROM owners
                                 WHERE EGN LIKE ?
                                 AND Hidden = 0";

    const GET_BY_EGN = "SELECT
                        EGN, City, FirstName, FamilyName, Address
                        FROM owners
                        WHERE EGN = ? 
                        AND Hidden = 0";

    const UPDATE_OWNER = "UPDATE owners SET
                          City = ?, FirstName = ?, FamilyName = ?, Address = ?
                          WHERE EGN = ?";

    const DELETE_OWNER = "UPDATE owners SET
                          Hidden = 1
                          WHERE ID = ?";

    const HIDE_EGN = "UPDATE owners SET
                      EGN = ?
                      WHERE ID = ?";

    private function __construct()
    {
        $this->pdo = DBManager::getInstance()->dbConnect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new OwnerDao();
        }
        return self::$instance;
    }

    function addOwner(Owner $owner)
    {
        $managerUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare( self::ADD_OWNER);
            $statement->execute(array($owner->getEGN(), $owner->getCity(), $owner->getName(), $owner->getFamilyName(), $owner->getAddress()));

            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $managerUsername, "Added Owner", $owner->getEGN(), "owners"));

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }

    }
    function getIdByEGN($egn) {
        $statement = $this->pdo->prepare( self::GET_ID_BY_EGN);
        $statement->execute(array($egn));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['ID'];
    }
    function getEGNByID($id) {
        $statement = $this->pdo->prepare( self::GET_EGN_BY_ID);
        $statement->execute(array($id));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['EGN'];
    }
    function getEgnSuggestions ($partOfEGN) {
        $statement = $this->pdo->prepare( self::GET_EGN_SUGGESTIONS);
        $statement->execute(array("$partOfEGN%"));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function getByEGN($egn) {
        $statement = $this->pdo->prepare( self::GET_BY_EGN);
        $statement->execute(array($egn));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    function updateOwner (Owner $owner){
        $managerUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare( self::UPDATE_OWNER);
            $statement->execute(array($owner->getCity(), $owner->getName(), $owner->getFamilyName(), $owner->getAddress(), $owner->getEGN()));

            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $managerUsername, "Edited Owner", $owner->getEGN(), "owners"));

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
        }
    function deleteOwnerByEGN ($egn) {
        $managerUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();

            $ownerId = $this->getIdByEGN($egn);

            $statement = $this->pdo->prepare( self::DELETE_OWNER);
            $statement->execute(array($ownerId));

            $statement = $this->pdo->prepare( self::HIDE_EGN);
            $statement->execute(array("H_" . time(), $ownerId));

            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $managerUsername, "Deleted Owner", $egn, "owners"));

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return $e->getMessage();
        }
    }
}