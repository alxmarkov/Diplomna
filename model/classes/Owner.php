<?php

namespace model\classes;

class Owner {
    private $ID;
    private $EGN;
    private $City;
    private $Name;
    private $FamilyName;
    private $Address;

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getEGN()
    {
        return $this->EGN;
    }

    /**
     * @param mixed $EGN
     */
    public function setEGN($EGN)
    {
        $this->EGN = $EGN;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param mixed $City
     */
    public function setCity($City)
    {
        $this->City = $City;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getFamilyName()
    {
        return $this->FamilyName;
    }

    /**
     * @param mixed $FamilyName
     */
    public function setFamilyName($FamilyName)
    {
        $this->FamilyName = $FamilyName;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param mixed $Address
     */
    public function setAddress($Address)
    {
        $this->Address = $Address;
    }


}