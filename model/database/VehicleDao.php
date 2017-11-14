<?php

namespace model\database;

use PDO;
use PDOException;
use model\classes\Vehicle;

class VehicleDao
{
    private static $instance;
    private $pdo;

    const ADD_LOG = "INSERT INTO log 
                      (DateTimes, Usernames, Actions, Records, Tables) 
                      VALUES 
                      (?, ?, ?, ?, ?)";

    const ADD_VEHICLE = "INSERT INTO vehicles 
                          (VIN, Numberplate, Type, Make, Model, EngineType, EngineSize, DateOfFirstRegistration, Color, PicturePath, OwnerID) 
                          VALUES 
                          (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private function __construct()
    {
        $this->pdo = DBManager::getInstance()->dbConnect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new VehicleDao();
        }
        return self::$instance;
    }

    function addVehicle(Vehicle $vehicle)
    {
        $managerUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare(self::ADD_VEHICLE);
            $statement->execute(array($vehicle->getVIN(), $vehicle->getNumberPlate(), $vehicle->getType(), $vehicle->getMake(), $vehicle->getModel(), $vehicle->getEngineType(), $vehicle->getEngineSize(), $vehicle->getYearOfMfg(), $vehicle->getColor(), $vehicle->getPicturePath(), $vehicle->getOwnerID()));

            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $managerUsername, "Added Vehicle", $vehicle->getVIN(), "vehicles"));

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