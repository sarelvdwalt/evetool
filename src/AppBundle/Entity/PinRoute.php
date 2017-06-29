<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PinRoute
 *
 * @ORM\Table(name="pin_route")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PinRouteRepository")
 */
class PinRoute extends BaseEntity
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
     * @ORM\Column(name="content_type_id", type="integer")
     */
    private $contentTypeId;

    /**
     * @var int
     *
     * @ORM\Column(name="destination_pin_id", type="bigint")
     */
    private $destinationPinId;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="route_id", type="bigint")
     */
    private $routeId;

    /**
     * @var int
     *
     * @ORM\Column(name="source_pin_id", type="bigint")
     */
    private $sourcePinId;


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
     * Set contentTypeId
     *
     * @param integer $contentTypeId
     *
     * @return PinRoute
     */
    public function setContentTypeId($contentTypeId)
    {
        $this->contentTypeId = $contentTypeId;

        return $this;
    }

    /**
     * Get contentTypeId
     *
     * @return int
     */
    public function getContentTypeId()
    {
        return $this->contentTypeId;
    }

    /**
     * Set destinationPinId
     *
     * @param integer $destinationPinId
     *
     * @return PinRoute
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return PinRoute
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set routeId
     *
     * @param integer $routeId
     *
     * @return PinRoute
     */
    public function setRouteId($routeId)
    {
        $this->routeId = $routeId;

        return $this;
    }

    /**
     * Get routeId
     *
     * @return int
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * Set sourcePinId
     *
     * @param integer $sourcePinId
     *
     * @return PinRoute
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
}
