<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PinLink
 *
 * @ORM\Table(name="pin_link")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PinLinkRepository")
 */
class PinLink extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="destination_pin_id", type="bigint")
     */
    private $destinationPinId;

    /**
     * @var int
     *
     * @ORM\Column(name="source_pin_id", type="bigint")
     */
    private $sourcePinId;

    /**
     * @var int
     *
     * @ORM\Column(name="link_level", type="integer")
     */
    private $linkLevel;


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
     * Set destinationPinId
     *
     * @param integer $destinationPinId
     *
     * @return PinLink
     */
    public function setDestinationPinId($destinationPinId)
    {
        $this->destinationPinId = $destinationPinId;

        return $this;
    }

    /**
     * Get destinationPinId
     *
     * @return int
     */
    public function getDestinationPinId()
    {
        return $this->destinationPinId;
    }

    /**
     * Set sourcePinId
     *
     * @param integer $sourcePinId
     *
     * @return PinLink
     */
    public function setSourcePinId($sourcePinId)
    {
        $this->sourcePinId = $sourcePinId;

        return $this;
    }

    /**
     * Get sourcePinId
     *
     * @return int
     */
    public function getSourcePinId()
    {
        return $this->sourcePinId;
    }

    /**
     * Set linkLevel
     *
     * @param integer $linkLevel
     *
     * @return PinLink
     */
    public function setLinkLevel($linkLevel)
    {
        $this->linkLevel = $linkLevel;

        return $this;
    }

    /**
     * Get linkLevel
     *
     * @return int
     */
    public function getLinkLevel()
    {
        return $this->linkLevel;
    }
}
