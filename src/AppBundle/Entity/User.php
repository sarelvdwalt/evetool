<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Toon", mappedBy="user")
     */
    protected $toons;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add toon
     *
     * @param \AppBundle\Entity\Toon $toon
     *
     * @return User
     */
    public function addToon(\AppBundle\Entity\Toon $toon)
    {
        $this->toons[] = $toon;

        return $this;
    }

    /**
     * Remove toon
     *
     * @param \AppBundle\Entity\Toon $toon
     */
    public function removeToon(\AppBundle\Entity\Toon $toon)
    {
        $this->toons->removeElement($toon);
    }

    /**
     * Get toons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToons()
    {
        return $this->toons;
    }
}
