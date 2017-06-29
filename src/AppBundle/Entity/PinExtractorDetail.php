<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PinExtractorDetail
 *
 * @ORM\Table(name="pin_extractor_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PinExtractorDetailRepository")
 */
class PinExtractorDetail extends BaseEntity
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
     * @var Pin
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Pin")
     * @ORM\JoinColumn(nullable=false, name="pin_id", referencedColumnName="id")
     */
    private $pin;

    /**
     * @var int
     *
     * @ORM\Column(name="cycle_time", type="integer")
     */
    private $cycleTime;

    /**
     * @var float
     *
     * @ORM\Column(name="head_radius", type="float")
     */
    private $headRadius;

    /**
     * @var int
     *
     * @ORM\Column(name="product_type_id", type="integer")
     */
    private $productTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="qty_per_cycle", type="string", length=255)
     */
    private $qtyPerCycle;


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
     * Get cycleTime
     *
     * @return int
     */
    public function getCycleTime()
    {
        return $this->cycleTime;
    }

    /**
     * Set cycleTime
     *
     * @param integer $cycleTime
     *
     * @return PinExtractorDetail
     */
    public function setCycleTime($cycleTime)
    {
        $this->cycleTime = $cycleTime;

        return $this;
    }

    /**
     * Get headRadius
     *
     * @return float
     */
    public function getHeadRadius()
    {
        return $this->headRadius;
    }

    /**
     * Set headRadius
     *
     * @param float $headRadius
     *
     * @return PinExtractorDetail
     */
    public function setHeadRadius($headRadius)
    {
        $this->headRadius = $headRadius;

        return $this;
    }

    /**
     * Get productTypeId
     *
     * @return int
     */
    public function getProductTypeId()
    {
        return $this->productTypeId;
    }

    /**
     * Set productTypeId
     *
     * @param integer $productTypeId
     *
     * @return PinExtractorDetail
     */
    public function setProductTypeId($productTypeId)
    {
        $this->productTypeId = $productTypeId;

        return $this;
    }

    /**
     * Get qtyPerCycle
     *
     * @return string
     */
    public function getQtyPerCycle()
    {
        return $this->qtyPerCycle;
    }

    /**
     * Set qtyPerCycle
     *
     * @param string $qtyPerCycle
     *
     * @return PinExtractorDetail
     */
    public function setQtyPerCycle($qtyPerCycle)
    {
        $this->qtyPerCycle = $qtyPerCycle;

        return $this;
    }

    /**
     * Get pin
     *
     * @return \AppBundle\Entity\Pin
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set pin
     *
     * @param \AppBundle\Entity\Pin $pin
     *
     * @return PinExtractorDetail
     */
    public function setPin(\AppBundle\Entity\Pin $pin = null)
    {
        $this->pin = $pin;

        return $this;
    }
}
