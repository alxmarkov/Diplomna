<?php

namespace model\database;

use PDO;
use PDOException;
use model\classes\User;

class UserDao
{
    private static $instance;
    private $pdo;

    const ADD_LOG = "INSERT INTO log 
                      (DateTimes, Usernames, Actions, Records, Tables) 
                      VALUES 
                      (?, ?, ?, ?, ?)";

    const ADD_USER = "INSERT INTO logins 
                      (Username, Password, Role, Active, DateAdded) 
                      VALUES 
                      (?, ?, ?, ?, ?)";

    const CHANGE_ACTIVE = "UPDATE logins 
                            SET Active=? 
                            WHERE Username=?";

    const LOG_IN = "SELECT 
                    ID, Username, Password, Role, Active, DateAdded 
                    FROM logins 
                    WHERE Username = ?";

    const GET_NEWEST_USERS = "SELECT 
                              logins.Username, logins.Role, logins.Active
                              FROM logins 
                              ORDER BY logins.DateAdded DESC 
                              LIMIT 5";

    const GET_USERNAME_SUGGESTIONS = "SELECT
                                 Username
                                 FROM logins
                                 WHERE Username LIKE ?";

    private function __construct()
    {
        $this->pdo = DBManager::getInstance()->dbConnect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new UserDao();
        }
        return self::$instance;
    }

    private function sqlResultToUsersArray(Array $sqlResultSet) {
        if(isset($sqlResultSet[0])) {
            $usersArray = array();
            foreach ($sqlResultSet as $key => $value) {
                $usersArray[] = new User(
                    $sqlResultSet[$key]['ID'],
                    $sqlResultSet[$key]['Username'],
                    $sqlResultSet[$key]['Password'],
                    $sqlResultSet[$key]['Role'],
                    $sqlResultSet[$key]['Active'],
                    $sqlResultSet[$key]['DateAdded']
                );
            }
            return $usersArray;
        }
        elseif (isset($sqlResultSet['ID'])) {
            $user = new User(
                $sqlResultSet['ID'],
                $sqlResultSet['Username'],
                $sqlResultSet['Password'],
                $sqlResultSet['Role'],
                $sqlResultSet['Active'],
                $sqlResultSet['DateAdded']
            );
            return $user;
        }
        else {
            return array();
        }
    }



    function addUser(User $user)
    {
        session_start();
        $adminUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare(self::ADD_USER);
            $statement->execute(array($user->getUsername(),
                                        password_hash($user->getPassword(), PASSWORD_DEFAULT),
                                        $user->getRole(),
                                        "YES",
                                        $date));

            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $adminUsername, "Added User", $user->getUsername(), "logins"));
            $this->pdo->commit();
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }

    }

    function changeUserActive($username, $state, $logMessage)
    {
        session_start();
        $adminUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare(self::CHANGE_ACTIVE);
            $statement->execute(array($state, $username));
            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $adminUsername, $logMessage, $username, "logins"));
            $this->pdo->commit();
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    function userLogin($username, $password = null)
    {
        $date = date("Y-m-d h:i:sa");
        $statement = $this->pdo->prepare(self::LOG_IN);
        $statement->execute(array($username));

        if ($password == null) {
            return $statement->rowCount() > 0;
        }
        if ($statement->rowCount() > 0) {
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user["Password"])) {
                if ($user["Active"] == "YES") {
                    $statement = $this->pdo->prepare(self::ADD_LOG);
                    $statement->execute(array($date, $username, "Logged In Successfully", null, null));
                    return $this->sqlResultToUsersArray($user);
                } else {
                    $statement = $this->pdo->prepare(self::ADD_LOG);
                    $statement->execute(array($date, $username, "Failed login: Blocked Account", null, null));
                    return false;
                }
            } else {
                $statement = $this->pdo->prepare(self::ADD_LOG);
                $statement->execute(array($date, $username, "Failed login: Wrong Password", null, null));
                return false;
            }
        } else {
            return false;
        }

    }

    function userLogout()
    {
        $date = date("Y-m-d h:i:sa");
        $username = $_SESSION['user']->getUsername();
        $statement = $this->pdo->prepare(self::ADD_LOG);
        $statement->execute(array($date, $username, "Logged Out", null, null));

    }

    function getLastAddedUsers()
    {
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $statement = $this->pdo->prepare(self::GET_NEWEST_USERS);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    function getUsernameSuggestions ($partOfUsername) {
        $statement = $this->pdo->prepare( self::GET_USERNAME_SUGGESTIONS);
        $statement->execute(array("$partOfUsername%"));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}