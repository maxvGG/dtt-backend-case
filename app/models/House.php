<?php

class House extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $street;

    /**
     *
     * @var integer
     */
    protected $number;

    /**
     *
     * @var string
     */
    protected $addition;

    /**
     *
     * @var string
     */
    protected $zipcode;

    /**
     *
     * @var string
     */
    protected $city;

    /**
     *
     * @var integer
     */
    protected $bedroomCount;

    /**
     *
     * @var integer
     */
    protected $livingroomCount;

    /**
     *
     * @var integer
     */
    protected $bathroomCount;

    /**
     *
     * @var integer
     */
    protected $toiletCount;

    /**
     *
     * @var integer
     */
    protected $storageCount;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field street
     *
     * @param string $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Method to set the value of field number
     *
     * @param integer $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Method to set the value of field addition
     *
     * @param string $addition
     * @return $this
     */
    public function setAddition($addition)
    {
        $this->addition = $addition;

        return $this;
    }

    /**
     * Method to set the value of field zipcode
     *
     * @param string $zipcode
     * @return $this
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Method to set the value of field city
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Method to set the value of field bedroomCount
     *
     * @param integer $bedroomCount
     * @return $this
     */
    public function setBedroomCount($bedroomCount)
    {
        $this->bedroomCount = $bedroomCount;

        return $this;
    }

    /**
     * Method to set the value of field livingroomCount
     *
     * @param integer $livingroomCount
     * @return $this
     */
    public function setLivingroomCount($livingroomCount)
    {
        $this->livingroomCount = $livingroomCount;

        return $this;
    }

    /**
     * Method to set the value of field bathroomCount
     *
     * @param integer $bathroomCount
     * @return $this
     */
    public function setBathroomCount($bathroomCount)
    {
        $this->bathroomCount = $bathroomCount;

        return $this;
    }

    /**
     * Method to set the value of field toiletCount
     *
     * @param integer $toiletCount
     * @return $this
     */
    public function setToiletCount($toiletCount)
    {
        $this->toiletCount = $toiletCount;

        return $this;
    }
    /**
     * Method to set the value of field createdByUserId
     *
     * @param integer $createdByUserId
     * @return $this
     */
    public function setcreatedByUserId($createdByUserId)
    {
        $this->createdByUserId = $createdByUserId;

        return $this;
    }
    /**
     * Method to set the value of field storageCount
     *
     * @param integer $storageCount
     * @return $this
     */
    public function setStorageCount($storageCount)
    {
        $this->storageCount = $storageCount;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Returns the value of field number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Returns the value of field addition
     *
     * @return string
     */
    public function getAddition()
    {
        return $this->addition;
    }

    /**
     * Returns the value of field zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Returns the value of field city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Returns the value of field bedroomCount
     *
     * @return integer
     */
    public function getBedroomCount()
    {
        return $this->bedroomCount;
    }

    /**
     * Returns the value of field livingroomCount
     *
     * @return integer
     */
    public function getLivingroomCount()
    {
        return $this->livingroomCount;
    }

    /**
     * Returns the value of field bathroomCount
     *
     * @return integer
     */
    public function getBathroomCount()
    {
        return $this->bathroomCount;
    }

    /**
     * Returns the value of field toiletCount
     *
     * @return integer
     */
    public function getToiletCount()
    {
        return $this->toiletCount;
    }

    /**
     * Returns the value of field storageCount
     *
     * @return integer
     */
    public function getStorageCount()
    {
        return $this->storageCount;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("dtt");
        $this->setSource("house");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return House[]|House|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return House|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }
}
