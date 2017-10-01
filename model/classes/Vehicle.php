<?php

class Vehicle {
    private $VIN;
    private $NumberPlate;
    private $Make;
    private $Model;
    private $EngineType;
    private $EngineSize;
    private $YearOfMfg;
    private $Color;
    private $PicturePath;
    private $OwnerID;

    /**
     * @return mixed
     */
    public function getVIN()
    {
        return $this->VIN;
    }

    /**
     * @param mixed $VIN
     */
    public function setVIN($VIN)
    {
        $this->VIN = $VIN;
    }

    /**
     * @return mixed
     */
    public function getNumberPlate()
    {
        return $this->NumberPlate;
    }

    /**
     * @param mixed $NumberPlate
     */
    public function setNumberPlate($NumberPlate)
    {
        $this->NumberPlate = $NumberPlate;
    }

    /**
     * @return mixed
     */
    public function getMake()
    {
        return $this->Make;
    }

    /**
     * @param mixed $Make
     */
    public function setMake($Make)
    {
        $this->Make = $Make;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->Model;
    }

    /**
     * @param mixed $Model
     */
    public function setModel($Model)
    {
        $this->Model = $Model;
    }

    /**
     * @return mixed
     */
    public function getEngineType()
    {
        return $this->EngineType;
    }

    /**
     * @param mixed $EngineType
     */
    public function setEngineType($EngineType)
    {
        $this->EngineType = $EngineType;
    }

    /**
     * @return mixed
     */
    public function getEngineSize()
    {
        return $this->EngineSize;
    }

    /**
     * @param mixed $EngineSize
     */
    public function setEngineSize($EngineSize)
    {
        $this->EngineSize = $EngineSize;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->Color;
    }

    /**
     * @param mixed $Color
     */
    public function setColor($Color)
    {
        $this->Color = $Color;
    }

    /**
     * @return mixed
     */
    public function getYearOfMfg()
    {
        return $this->YearOfMfg;
    }

    /**
     * @param mixed $YearOfMfg
     */
    public function setYearOfMfg($YearOfMfg)
    {
        $this->YearOfMfg = $YearOfMfg;
    }

    /**
     * @return mixed
     */
    public function getPicturePath()
    {
        return $this->PicturePath;
    }

    /**
     * @param mixed $PicturePath
     */
    public function setPicturePath($PicturePath)
    {
        $this->PicturePath = $PicturePath;
    }

    /**
     * @return mixed
     */
    public function getOwnerID()
    {
        return $this->OwnerID;
    }

    /**
     * @param mixed $OwnerID
     */
    public function setOwnerID($OwnerID)
    {
        $this->OwnerID = $OwnerID;
    }


}