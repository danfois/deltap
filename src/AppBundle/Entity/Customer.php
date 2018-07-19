<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Column(type="integer", name="idCustomer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCustomer;

    /**
     * @ORM\Column(type="string", length=160, nullable=false, name="business_name")
     * @Assert\NotBlank(message="Business Name cannot be blank")
     * @Assert\Length(
     *     max = 160,
     *     maxMessage = "The Business name can have 160 characters max"
     * )
     */
    private $businessName;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="addressId")
     */
    private $fullAddress;

    /**
     * @ORM\Column(type="string", nullable=true, length=12, name="phone")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="The Phone can contain at maximum 12 digits"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true, length=12, name="mobile")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="The Mobile can contain at maximum 12 digits"
     * )
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", nullable=true, length=12, name="fax")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="The Fax can contain at maximum 12 digits"
     * )
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, name="email")
     * @Assert\NotBlank(message="Email address cannot be empty.")
     * @Assert\Email(message="The email address you provided is not valid.", checkMX=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=12, nullable=true, name="vat")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="Vat Number can contain at maximum 12 digits"
     * )
     */
    private $vat;

    /**
     * @ORM\Column(type="string", length=16, nullable=true, name="cf")
     * @Assert\Length(
     *     max=12,
     *     maxMessage="Fiscal Code can contain at maximum 16 digits"
     * )
     */
    private $cf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="website")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Website can have at maximum 255 characters"
     * )
     */
    private $website;

    /**
     * @ORM\OneToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category", referencedColumnName="category_id")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @Assert\Length(max=32, maxMessage="Cuu can have at maximum 32 characters")
     */
    private $cuu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="tags")
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime", name="registration_date", nullable=true)
     */
    private $registration_date;


    /**
     * Get idCustomer
     *
     * @return integer
     */
    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    /**
     * Set businessName
     *
     * @param string $businessName
     *
     * @return Customer
     */
    public function setBusinessName($businessName)
    {
        $this->businessName = $businessName;

        return $this;
    }

    /**
     * Get businessName
     *
     * @return string
     */
    public function getBusinessName()
    {
        return $this->businessName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Customer
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Customer
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set vat
     *
     * @param string $vat
     *
     * @return Customer
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return string
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set cf
     *
     * @param string $cf
     *
     * @return Customer
     */
    public function setCf($cf)
    {
        $this->cf = $cf;

        return $this;
    }

    /**
     * Get cf
     *
     * @return string
     */
    public function getCf()
    {
        return $this->cf;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Customer
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set cuu
     *
     * @param string $cuu
     *
     * @return Customer
     */
    public function setCuu($cuu)
    {
        $this->cuu = $cuu;

        return $this;
    }

    /**
     * Get cuu
     *
     * @return string
     */
    public function getCuu()
    {
        return $this->cuu;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Customer
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return Customer
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registration_date = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registration_date;
    }

    /**
     * Set fullAddress
     *
     * @param \AppBundle\Entity\Address $fullAddress
     *
     * @return Customer
     */
    public function setFullAddress(\AppBundle\Entity\Address $fullAddress = null)
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }

    /**
     * Get fullAddress
     *
     * @return \AppBundle\Entity\Address
     */
    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Customer
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
