<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Toon
 *
 * @ORM\Table(name="toon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ToonRepository")
 */
class Toon
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

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
     * @ORM\Column(name="expires_in", type="string", length=255)
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
}

