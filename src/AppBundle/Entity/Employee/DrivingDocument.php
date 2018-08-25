<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @MappedSuperClass
 */
class DrivingDocument
{
    /**
     * @ORM\Column(type="string", nullable=false, length=24, name="number")
     * @Assert\NotBlank(message="Number cannot be null")
     * @Assert\Length(max=24, maxMessage="Number is too long. Max 24 chars.")
     */
    protected $number;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="expiration")
     * @Assert\NotBlank(message="Expiration cannot be null")
     */
    protected $expiration;

    /**
     * @ORM\Column(type="string", length=128, nullable=false, name="releasedBy")
     * @Assert\NotBlank()
     * @Assert\Length(max=128)
     */
    protected $releasedBy;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="releaseDate")
     * @Assert\NotBlank(message="Release date cannot be null")
     */
    protected $releaseDate;

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return DrivingDocument
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param mixed $expiration
     * @return DrivingDocument
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReleasedBy()
    {
        return $this->releasedBy;
    }

    /**
     * @param mixed $releasedBy
     * @return DrivingDocument
     */
    public function setReleasedBy($releasedBy)
    {
        $this->releasedBy = $releasedBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     * @return DrivingDocument
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }
}