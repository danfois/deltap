<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @ORM\Table(name="customers")
 * @UniqueEntity("vat", message="A Customer with this Vat Number already exists in the database")
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
     * @ORM\OneToOne(targetEntity="Address")
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
     * @ORM\JoinColumn(name="category", referencedColumnName="categoryId")
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

}