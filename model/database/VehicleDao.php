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

    const GET_NUMBERPLATE_SUGGESTIONS = "SELECT
                                 Numberplate
                                 FROM vehicles
                                 WHERE Numberplate LIKE ?
                                 AND Hidden = 0";

    const GET_BY_NP = "SELECT
                        VIN, Numberplate, Type, Make, Model, EngineType, EngineSize, DateOfFirstRegistration, Color, PicturePath, OwnerID
                        FROM vehicles
                        WHERE Numberplate = ?";

    const UPDATE_VEHICLE = "UPDATE vehicles SET
                          Numberplate = ?, EngineType = ?, EngineSize = ?, Color = ?, OwnerID = ?
                          WHERE VIN = ?";

    const GET_ID_BY_NP = "SELECT
                            ID
                            FROM vehicles
                            WHERE Numberplate = ?";

    const DELETE_VEHICLE = "UPDATE vehicles SET
                          Hidden = 1
                          WHERE ID = ?";

    const HIDE_NP = "UPDATE vehicles SET
                      Numberplate = ?
                      WHERE ID = ?";

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
            return false;
        }
    }

    function getNumberplateSuggestions ($partOfNP) {
        $statement = $this->pdo->prepare( self::GET_NUMBERPLATE_SUGGESTIONS);
        $statement->execute(array("$partOfNP%"));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getByNP($np) {
        $statement = $this->pdo->prepare( self::GET_BY_NP);
        $statement->execute(array($np));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $ownerDao = OwnerDao::getInstance();
        $egn = $ownerDao->getEGNByID($result['OwnerID']);
        $result['OwnerID'] = $egn;
        return $result;
    }

    function updateVehicle (Vehicle $vehicle){
        $managerUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare( self::UPDATE_VEHICLE);
            $statement->execute(array($vehicle->getNumberPlate(), $vehicle->getEngineType(), $vehicle->getEngineSize(), $vehicle->getColor(), $vehicle->getOwnerID(), $vehicle->getVIN()));

            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $managerUsername, "Edited Vehicle", $vehicle->getVIN(), "vehicles"));

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return $e->getMessage();
        }
    }
    function getIdByNumberplate($np) {
        $statement = $this->pdo->prepare( self::GET_ID_BY_NP);
        $statement->execute(array($np));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['ID'];
    }
    function deleteVehicleByNp ($numberplate) {
        $managerUsername = $_SESSION['user']->getUsername();
        $date = date("Y-m-d h:i:sa");
        try {
            $this->pdo->beginTransaction();

            $vehicleId = $this->getIdByNumberplate($numberplate);

            $statement = $this->pdo->prepare( self::DELETE_VEHICLE);
            $statement->execute(array($vehicleId));

            $statement = $this->pdo->prepare( self::HIDE_NP);
            $statement->execute(array("H_" . time(), $vehicleId));

            $statement = $this->pdo->prepare(self::ADD_LOG);
            $statement->execute(array($date, $managerUsername, "Deleted Vehicle", $numberplate, "vehicles"));

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }
}