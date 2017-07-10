<?php

namespace sarelvdwalt\EVESDEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * invUniqueName
 *
 * @ORM\Table(name="invUniqueNames")
 * @ORM\Entity(repositoryClass="sarelvdwalt\EVESDEBundle\Repository\invUniqueNameRepository")
 */
class invUniqueName
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="itemID", type="integer")
     */
    private $itemID;

    /**
     * @var string
     *
     * @ORM\Column(name="itemName", type="string", length=200)
     */
    private $itemName;

    /**
     * @var int
     *
     * @ORM\Column(name="groupID", type="integer")
     */
    private $groupID;

    /**
     * Set itemID
     *
     * @param integer $itemID
     *
     * @return invUniqueName
     */
    public function setItemID($itemID)
    {
        $this->itemID = $itemID;

        return $this;
    }

    /**
     * Get itemID
     *
     * @return int
     */
    public function getItemID()
    {
        return $this->itemID;
    }

    /**
     * Set itemName
     *
     * @param string $itemName
     *
     * @return invUniqueName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * Set groupID
     *
     * @param integer $groupID
     *
     * @return invUniqueName
     */
    public function setGroupID($groupID)
    {
        $this->groupID = $groupID;

        return $this;
    }

    /**
     * Get groupID
     *
     * @return int
     */
    public function getGroupID()
    {
        return $this->groupID;
    }
}

