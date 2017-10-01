<?php

require_once "dbmanager.php";

function addUser($username, $password, $role) {
    $date = date("Y-m-d h:i:sa");
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $statement = $pdo->prepare("INSERT INTO logins (Username, Password, Role, Active, DateAdded) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($username, password_hash($password, PASSWORD_DEFAULT), $role, "YES", $date));
        $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES (?, ? , ?, ?, ?)");
        $statement->execute(array($date, $_SESSION['username'], "Added User", $username, "logins"));
        $pdo->commit();
    }
    catch (PDOException $e) {
        if (isset($pdo)) {
            $pdo->rollBack();
        }
    }

}

function changeUserActive($username, $state, $logMessage) {
    $date = date("Y-m-d h:i:sa");
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $statement = $pdo->prepare("UPDATE logins SET Active=? WHERE Username=?");
        $statement->execute(array($state, $username));
        $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES (?, ? , ?, ?, ?)");
        $statement->execute(array($date, $_SESSION['username'], $logMessage, $username, "logins"));
        $pdo->commit();
    }
    catch (PDOException $e) {
        if (isset($pdo)) {
            $pdo->rollBack();
        }
    }
}

function userLogin($username, $password = null){
    $date = date("Y-m-d h:i:sa");
    try{
        $pdo = getConnection();
        $statement = $pdo->prepare("SELECT Username, Password, Role, Active FROM logins WHERE Username = ?");
        $statement->execute(array($username));

        if($password == null){
            return $statement->rowCount() > 0;
        }
        if($statement->rowCount() > 0){
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $user["Password"])){
                if ($user["Active"] == "YES") {
                    $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions) VALUES (?, ?, ?)");
                    $statement->execute(array($date, $username, "Logged In Successfully"));
                    return $user;
                }
                else {
                    $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions) VALUES (?, ?, ?)");
                    $statement->execute(array($date, $username, "Failed login: Blocked Account"));
                    return false;
                }
            }
            else{
                $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions) VALUES (?, ?, ?)");
                $statement->execute(array($date, $username, "Failed login: Wrong Password"));
                return false;
            }
        }
        else{
            return false;
        }
    }
    catch (PDOException $e){
        return false;
    }
}

function userLogout ($username) {
    $date = date("Y-m-d h:i:sa");
    try {
        $pdo = getConnection();
        $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions) VALUES (?, ?, ?)");
        $statement->execute(array($date, $username, "Logged Out"));
    }
    catch (PDOException $e) {

    }
}

function getLogPage ($offset = 0) {
    try {
        $pdo = getConnection();
        if ($offset == 0) {
            $statement = $pdo->prepare("SELECT * FROM log ORDER BY ID DESC LIMIT 10");
            $statement->execute();
        }
        else {
            $statement = $pdo->prepare("SELECT * FROM log ORDER BY ID DESC LIMIT $offset, 10");
            $statement->execute();
        }
        $logPage = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $logPage;
    }
    catch (PDOException $e) {
        return $e->getMessage();
    }

}

function getLastAddedUsers() {
    $pdo = getConnection();
    $statement = $pdo->prepare("SELECT logins.Username, logins.Role, logins.Active FROM logins ORDER BY logins.DateAdded DESC LIMIT 5");
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function getLastFiveLogEntries() {
    try {
        $pdo = getConnection();
        $statement = $pdo->prepare("SELECT * FROM log ORDER BY ID DESC LIMIT 5");
        $statement->execute();
        $log = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $log;
    }
    catch (PDOException $e) {
        return false;
    }
}