<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Toon
 *
 * @ORM\Table(name="toon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ToonRepository")
 */
class Toon extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="toons")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Colony", mappedBy="toon")
     */
    private $colonies;

    /**
     * @var string
     *
     * @ORM\Column(name="character_name", type="string", length=255)
     */
    private $characterName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_on", type="datetime")
     */
    private $expiresOn;

    /**
     * @var string
     *
     * @ORM\Column(name="scopes", type="string", length=255)
     */
    private $scopes;

    /**
     * @var string
     *
     * @ORM\Column(name="token_type", type="string", length=255)
     */
    private $tokenType;

    /**
     * @var string
     *
     * @ORM\Column(name="character_owner_hash", type="string", length=255)
     */
    private $characterOwnerHash;

    /**
     * @var string
     *
     * @ORM\Column(name="intellectual_property", type="string", length=255)
     */
    private $intellectualProperty;

    /**
     * @var string
     * @ORM\Column(name="esi_access_token", type="string", length=255)
     */
    private $esiAccessToken;

    /**
     * @var string
     * @ORM\Column(name="esi_token_type", type="string", length=255)
     */
    private $esiTokenType;

    /**
     * @return string
     */
    public function getEsiAccessToken()
    {
        return $this->esiAccessToken;
    }

    /**
     * @param string $esiAccessToken
     */
    public function setEsiAccessToken($esiAccessToken)
    {
        $this->esiAccessToken = $esiAccessToken;
    }

    /**
     * @return string
     */
    public function getEsiTokenType()
    {
        return $this->esiTokenType;
    }

    /**
     * @param string $esiTokenType
     */
    public function setEsiTokenType($esiTokenType)
    {
        $this->esiTokenType = $esiTokenType;
    }

    /**
     * @return string
     */
    public function getEsiRefreshToken()
    {
        return $this->esiRefreshToken;
    }

    /**
     * @param string $esiRefreshToken
     */
    public function setEsiRefreshToken($esiRefreshToken)
    {
        $this->esiRefreshToken = $esiRefreshToken;
    }

    /**
     * @var string
     * @ORM\Column(name="esi_refresh_token", type="string", length=255)
     */
    private $esiRefreshToken;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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
     * Set characterName
     *
     * @param string $characterName
     *
     * @return Toon
     */
    public function setCharacterName($characterName)
    {
        $this->characterName = $characterName;

        return $this;
    }

    /**
     * Get characterName
     *
     * @return string
     */
    public function getCharacterName()
    {
        return $this->characterName;
    }

    /**
     * Set expiresOn
     *
     * @param \DateTime $expiresOn
     *
     * @return Toon
     */
    public function setExpiresOn($expiresOn)
    {
        $this->expiresOn = $expiresOn;

        return $this;
    }

    /**
     * Get expiresOn
     *
     * @return \DateTime
     */
    public function getExpiresOn()
    {
        return $this->expiresOn;
    }

    /**
     * Set scopes
     *
     * @param string $scopes
     *
     * @return Toon
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Get scopes
     *
     * @return string
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Set tokenType
     *
     * @param string $tokenType
     *
     * @return Toon
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;

        return $this;
    }

    /**
     * Get tokenType
     *
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * Set characterOwnerHash
     *
     * @param string $characterOwnerHash
     *
     * @return Toon
     */
    public function setCharacterOwnerHash($characterOwnerHash)
    {
        $this->characterOwnerHash = $characterOwnerHash;

        return $this;
    }

    /**
     * Get characterOwnerHash
     *
     * @return string
     */
    public function getCharacterOwnerHash()
    {
        return $this->characterOwnerHash;
    }

    /**
     * Set intellectualProperty
     *
     * @param string $intellectualProperty
     *
     * @return Toon
     */
    public function setIntellectualProperty($intellectualProperty)
    {
        $this->intellectualProperty = $intellectualProperty;

        return $this;
    }

    /**
     * Get intellectualProperty
     *
     * @return string
     */
    public function getIntellectualProperty()
    {
        return $this->intellectualProperty;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Toon
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->colonies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add colony
     *
     * @param \AppBundle\Entity\Colony $colony
     *
     * @return Toon
     */
    public function addColony(\AppBundle\Entity\Colony $colony)
    {
        $this->colonies[] = $colony;

        return $this;
    }

    /**
     * Remove colony
     *
     * @param \AppBundle\Entity\Colony $colony
     */
    public function removeColony(\AppBundle\Entity\Colony $colony)
    {
        $this->colonies->removeElement($colony);
    }

    /**
     * Get colonies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColonies()
    {
        return $this->colonies;
    }
}
