<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pin
 *
 * @ORM\Table(name="pin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PinRepository")
 */
class Pin extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Colony
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Colony")
     */
    private $colony;

    /**
     * @var int
     *
     * @ORM\Column(name="schematic_id", type="integer", nullable=true)
     */
    private $schematicId;

    /**
     * @var int
     *
     * @ORM\Column(name="type_id", type="integer")
     */
    private $typeId;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_cycle_start", type="datetime", nullable=true)
     */
    private $lastCycleStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="install_time", type="datetime", nullable=true)
     */
    private $installTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_time", type="datetime", nullable=true)
     */
    private $expiryTime;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set schematicId
     *
     * @param integer $schematicId
     *
     * @return Pin
     */
    public function setSchematicId($schematicId)
    {
        $this->schematicId = $schematicId;

        return $this;
    }

    /**
     * Get schematicId
     *
     * @return int
     */
    public function getSchematicId()
    {
        return $this->schematicId;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return Pin
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Pin
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Pin
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lastCycleStart
     *
     * @param \DateTime $lastCycleStart
     *
     * @return Pin
     */
    public function setLastCycleStart($lastCycleStart)
    {
        $this->lastCycleStart = $lastCycleStart;

        return $this;
    }

    /**
     * Get lastCycleStart
     *
     * @return \DateTime
     */
    public function getLastCycleStart()
    {
        return $this->lastCycleStart;
    }

    /**
     * Set installTime
     *
     * @param \DateTime $installTime
     *
     * @return Pin
     */
    public function setInstallTime($installTime)
    {
        $this->installTime = $installTime;

        return $this;
    }

    /**
     * Get installTime
     *
     * @return \DateTime
     */
    public function getInstallTime()
    {
        return $this->installTime;
    }

    /**
     * Set expiryTime
     *
     * @param \DateTime $expiryTime
     *
     * @return Pin
     */
    public function setExpiryTime($expiryTime)
    {
        $this->expiryTime = $expiryTime;

        return $this;
    }

    /**
     * Get expiryTime
     *
     * @return \DateTime
     */
    public function getExpiryTime()
    {
        return $this->expiryTime;
    }

    /**
     * Set colony
     *
     * @param \AppBundle\Entity\Colony $colony
     *
     * @return Pin
     */
    public function setColony(\AppBundle\Entity\Colony $colony = null)
    {
        $this->colony = $colony;

        return $this;
    }

    /**
     * Get colony
     *
     * @return \AppBundle\Entity\Colony
     */
    public function getColony()
    {
        return $this->colony;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Pin
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
