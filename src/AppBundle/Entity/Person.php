<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @MappedSuperClass
 */
abstract class Person implements Contactable
{
    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="name")
     * @Assert\NotBlank(message="Name cannot be null")
     * @Assert\Length(max=64, maxMessage="Name is too long. Max 64 chars")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="surname")
     * @Assert\NotBlank(message="Surname cannot be null")
     * @Assert\Length(max=64, maxMessage="Surname is too long. Max 64 chars")
     */
    protected $surname;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="birthDate")
     * @Assert\NotBlank(message="Date of birth cannot be null")
     */
    protected $birthDate;

    /**
     * @ORM\Column(type="string", nullable=false, name="birthPlace", length=128)
     * @Assert\NotBlank(message="Place of Birth cannot be null")
     * @Assert\Length(max=128, maxMessage="Birth of Place too long. Max 128 chars")
     */
    protected $birthPlace;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="addressId")
     */
    protected $fullAddress;

    /**
     * @ORM\Column(type="string", length=16, nullable=true, name="cf")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="Fiscal Code can contain at maximum 16 digits"
     * )
     */
    protected $cf;

    /**
     * @ORM\Column(type="string", nullable=true, length=12, name="phone")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="The Phone can contain at maximum 12 digits"
     * )
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", nullable=true, length=12, name="mobile")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="The Mobile can contain at maximum 12 digits"
     * )
     */
    protected $mobile;

    /**
     * @ORM\Column(type="string", nullable=true, length=12, name="fax")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="The Fax can contain at maximum 12 digits"
     * )
     */
    protected $fax;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, name="email")
     * @Assert\NotBlank(message="Email address cannot be empty.")
     * @Assert\Email(message="The email address you provided is not valid.", checkMX=false)
     */
    protected $email;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return Person
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     * @return Person
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthPlace()
    {
        return $this->birthPlace;
    }

    /**
     * @param mixed $birthPlace
     * @return Person
     */
    public function setBirthPlace($birthPlace)
    {
        $this->birthPlace = $birthPlace;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    /**
     * @param mixed $fullAddress
     * @return Person
     */
    public function setFullAddress($fullAddress)
    {
        $this->fullAddress = $fullAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCf()
    {
        return $this->cf;
    }

    /**
     * @param mixed $cf
     * @return Person
     */
    public function setCf($cf)
    {
        $this->cf = $cf;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     * @return Person
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     * @return Person
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

}
