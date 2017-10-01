<?php
require_once "dbmanager.php";

function addOwner (Owner $owner) {
    $date = date("Y-m-d h:i:sa");
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();

        $statement = $pdo->prepare("INSERT INTO owners (EGN, City, FirstName, FamilyName, Address) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($owner->getID(), $owner->getCity(), $owner->getName(), $owner->getFamilyName(), $owner->getAddress()));

        $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($date, $_SESSION['username'], "Added Owner", $owner->getID(), "owners"));

        $pdo->commit();
        return true;
    }
    catch (PDOException $e) {
        if(isset($pdo)) {
            $pdo->rollBack();
        }
        return false;
    }

}

function addVehicle(Vehicle $vehicle) {
    $date = date("Y-m-d h:i:sa");
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $statement = $pdo->prepare("INSERT INTO vehicles (VIN, Numberplate, Make, Model, EngineType, EngineSize, DateOfFirstRegistration, Color, PicturePath, OwnerID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($vehicle->getVIN(), $vehicle->getNumberPlate(), $vehicle->getMake(), $vehicle->getModel(), $vehicle->getEngineType(), $vehicle->getEngineSize(), $vehicle->getYearOfMfg(), $vehicle->getColor(), $vehicle->getPicturePath(), $vehicle->getOwnerID()));

        $statement = $pdo->prepare("INSERT INTO log (DateTimes, Usernames, Actions, Records, Tables) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($date, $_SESSION['username'], "Added Vehicle", $vehicle->getVIN(), "vehicles"));

        $pdo->commit();
        return true;
    }
    catch (PDOException $e) {
        if(isset($pdo)) {
            $pdo->rollBack();
        }
        return false;
    }
}