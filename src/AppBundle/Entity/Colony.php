<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Colony
 *
 * @ORM\Table(name="colony")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColonyRepository")
 */
class Colony extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Toon
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Toon", inversedBy="colonies")
     */
    private $toon;

    /**
     * @var int
     *
     * @ORM\Column(name="planet_id", type="integer")
     */
    private $planetId;

    /**
     * @var string
     *
     * @ORM\Column(name="planet_type", type="string", length=255)
     */
    private $planetType;

    /**
     * @var int
     *
     * @ORM\Column(name="solar_system_id", type="integer")
     */
    private $solarSystemId;

    /**
     * @var int
     *
     * @ORM\Column(name="upgrade_level", type="integer")
     */
    private $upgradeLevel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastUpdate;

    /**
     * @var int
     *
     * @ORM\Column(name="num_pins", type="integer")
     */
    private $numPins;


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
     * Set toonId
     *
     * @param integer $toonId
     *
     * @return Colony
     */
    public function setToonId($toonId)
    {
        $this->toonId = $toonId;

        return $this;
    }

    /**
     * Get toonId
     *
     * @return int
     */
    public function getToonId()
    {
        return $this->toonId;
    }

    /**
     * Set planetId
     *
     * @param integer $planetId
     *
     * @return Colony
     */
    public function setPlanetId($planetId)
    {
        $this->planetId = $planetId;

        return $this;
    }

    /**
     * Get planetId
     *
     * @return int
     */
    public function getPlanetId()
    {
        return $this->planetId;
    }

    /**
     * Set planetType
     *
     * @param string $planetType
     *
     * @return Colony
     */
    public function setPlanetType($planetType)
    {
        $this->planetType = $planetType;

        return $this;
    }

    /**
     * Get planetType
     *
     * @return string
     */
    public function getPlanetType()
    {
        return $this->planetType;
    }

    /**
     * Set solarSystemId
     *
     * @param integer $solarSystemId
     *
     * @return Colony
     */
    public function setSolarSystemId($solarSystemId)
    {
        $this->solarSystemId = $solarSystemId;

        return $this;
    }

    /**
     * Get solarSystemId
     *
     * @return int
     */
    public function getSolarSystemId()
    {
        return $this->solarSystemId;
    }

    /**
     * Set upgradeLevel
     *
     * @param integer $upgradeLevel
     *
     * @return Colony
     */
    public function setUpgradeLevel($upgradeLevel)
    {
        $this->upgradeLevel = $upgradeLevel;

        return $this;
    }

    /**
     * Get upgradeLevel
     *
     * @return int
     */
    public function getUpgradeLevel()
    {
        return $this->upgradeLevel;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     *
     * @return Colony
     */
    public function setLastUpdate($lastUpdate)
    {
//        VarDumper::dump($this->getLastUpdate());
//        VarDumper::dump($lastUpdate);

//        if ((null === $this->lastUpdate) || ($this->lastUpdate->getTimestamp() !== $lastUpdate->getTimestamp())) {
            $this->lastUpdate = $lastUpdate;
//            VarDumper::dump($this->lastUpdate);
//            VarDumper::dump($lastUpdate);
//            exit;
//            echo 'updating lastUpdate... ['.$this->lastUpdate->getTimestamp().' <> '.$lastUpdate->getTimestamp().']'.PHP_EOL;
//        }

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set numPins
     *
     * @param integer $numPins
     *
     * @return Colony
     */
    public function setNumPins($numPins)
    {
        $this->numPins = $numPins;

        return $this;
    }

    /**
     * Get numPins
     *
     * @return int
     */
    public function getNumPins()
    {
        return $this->numPins;
    }

    /**
     * Set toon
     *
     * @param \AppBundle\Entity\Toon $toon
     *
     * @return Colony
     */
    public function setToon(\AppBundle\Entity\Toon $toon = null)
    {
        $this->toon = $toon;

        return $this;
    }

    /**
     * Get toon
     *
     * @return \AppBundle\Entity\Toon
     */
    public function getToon()
    {
        return $this->toon;
    }
}
