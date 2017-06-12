<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Testator
 *
 * @ORM\Table(name="testator")
 * @ORM\Entity(repositoryClass="DataBundle\Repository\TestatorRepository")
 */
class Testator
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
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=255)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstnames", type="string", length=255)
     */
    private $firstnames;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=255)
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfBirth", type="date")
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="placeOfBirth", type="string", length=255)
     */
    private $placeOfBirth;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfDeath", type="date")
     */
    private $dateOfDeath;

    /**
     * @var string
     *
     * @ORM\Column(name="placeOfDeath", type="string", length=255)
     */
    private $placeOfDeath;

    /**
     * @var string
     *
     * @ORM\Column(name="deathMention", type="string", length=255)
     */
    private $deathMention;

    /**
     * @var string
     *
     * @ORM\Column(name="memoireDesHommes", type="string", length=255)
     */
    private $memoireDesHommes;

    /**
     * @var string
     *
     * @ORM\Column(name="regiment", type="string", length=255)
     */
    private $regiment;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=255)
     */
    private $rank;


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
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Testator
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Testator
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set firstnames
     *
     * @param string $firstnames
     *
     * @return Testator
     */
    public function setFirstnames($firstnames)
    {
        $this->firstnames = $firstnames;

        return $this;
    }

    /**
     * Get firstnames
     *
     * @return string
     */
    public function getFirstnames()
    {
        return $this->firstnames;
    }

    /**
     * Set profession
     *
     * @param string $profession
     *
     * @return Testator
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Testator
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Testator
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set placeOfBirth
     *
     * @param string $placeOfBirth
     *
     * @return Testator
     */
    public function setPlaceOfBirth($placeOfBirth)
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    /**
     * Get placeOfBirth
     *
     * @return string
     */
    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }

    /**
     * Set dateOfDeath
     *
     * @param \DateTime $dateOfDeath
     *
     * @return Testator
     */
    public function setDateOfDeath($dateOfDeath)
    {
        $this->dateOfDeath = $dateOfDeath;

        return $this;
    }

    /**
     * Get dateOfDeath
     *
     * @return \DateTime
     */
    public function getDateOfDeath()
    {
        return $this->dateOfDeath;
    }

    /**
     * Set placeOfDeath
     *
     * @param string $placeOfDeath
     *
     * @return Testator
     */
    public function setPlaceOfDeath($placeOfDeath)
    {
        $this->placeOfDeath = $placeOfDeath;

        return $this;
    }

    /**
     * Get placeOfDeath
     *
     * @return string
     */
    public function getPlaceOfDeath()
    {
        return $this->placeOfDeath;
    }

    /**
     * Set deathMention
     *
     * @param string $deathMention
     *
     * @return Testator
     */
    public function setDeathMention($deathMention)
    {
        $this->deathMention = $deathMention;

        return $this;
    }

    /**
     * Get deathMention
     *
     * @return string
     */
    public function getDeathMention()
    {
        return $this->deathMention;
    }

    /**
     * Set memoireDesHommes
     *
     * @param string $memoireDesHommes
     *
     * @return Testator
     */
    public function setMemoireDesHommes($memoireDesHommes)
    {
        $this->memoireDesHommes = $memoireDesHommes;

        return $this;
    }

    /**
     * Get memoireDesHommes
     *
     * @return string
     */
    public function getMemoireDesHommes()
    {
        return $this->memoireDesHommes;
    }

    /**
     * Set regiment
     *
     * @param string $regiment
     *
     * @return Testator
     */
    public function setRegiment($regiment)
    {
        $this->regiment = $regiment;

        return $this;
    }

    /**
     * Get regiment
     *
     * @return string
     */
    public function getRegiment()
    {
        return $this->regiment;
    }

    /**
     * Set rank
     *
     * @param string $rank
     *
     * @return Testator
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }
}
