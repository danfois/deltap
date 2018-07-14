<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceQuotationRepository")
 * @ORM\Table(name="price_quotations")
 */
class PriceQuotation
{
    /**
     * @ORM\Column(type="integer", name="quotationId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $quotationId;

    /**
     * @ORM\Column(type="datetime", name="quotation_date", nullable=true)
     */
    private $quotation_date;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="idCustomer")
     * @Assert\NotBlank(message="Customer must not be null")
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="request")
     * @Assert\Length(max=255, maxMessage="Request field cannot exceed 255 chars.")
     */
    private $request;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="contract")
     * @Assert\Length(max=255, maxMessage="Contract field cannot exceed 255 chars.")
     */
    private $contract;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, name="email")
     * @Assert\Email(message="The email address you provided is not valid", checkMX=false)
     * @Assert\NotBlank(message="The email cannot be empty")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="pec")
     * @Assert\Email(message="The pec address you provided is not valid", checkMX==false)
     */
    private $pec;

    /**
     * @ORM\Column(type="string", length=16, nullable=true, name="service_code")
     * @Assert\Length(max=16, maxMessage="The service code cannot exceed 16 chars.")
     */
    private $service_code;

    /**
     * @ORM\Column(type="integer, name="status", nullable=false, length=1)
     * @Assert\NotBlank(message="You have to select a status for the price quotation")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id_user")
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="Letter")
     * @ORM\JoinColumn(name="letter_id", referencedColumnName="letterId")
     */
    private $letter;
}