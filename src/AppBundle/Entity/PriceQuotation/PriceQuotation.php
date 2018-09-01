<?php

namespace AppBundle\Entity\PriceQuotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceQuotationRepository")
 * @ORM\Table(name="price_quotations")
 */
class PriceQuotation
{
    /**
     * @ORM\Column(type="integer", name="priceQuotationId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $priceQuotationId;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotationDetails", mappedBy="priceQuotation")
     */
    protected $priceQuotationDetails;

    /**
     * @ORM\Column(type="string", length=12, nullable=false, name="code")
     * @Assert\NotBlank(message="Price Quotation Code cannot be null")
     * @Assert\Length(max=12, maxMessage="Price Quotation Code is too long. Max 12 chars")
     */
    protected $code;

    /**
     * @ORM\Column(type="string", nullable=false, name="priceQuotationDate")
     * @Assert\NotBlank(message="Price Quotation Date cannot be null")
     */
    protected $priceQuotationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="idCustomer")
     */
    protected $customer;

    /**
     * @ORM\Column(type="string", nullable=true, name="contract")
     */
    protected $contract;

    /**
     * @ORM\OneToOne(targetEntity="Letter", cascade={"persist"})
     * @ORM\JoinColumn(name="letterId", referencedColumnName="letterId")
     */
    protected $letter;

    /**
     * @ORM\Column(type="string", nullable=true, name="request")
     */
    protected $request;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="receiver_mail")
     * @Assert\Email(message="The email address you provided is not valid", checkMX=false)
     * @Assert\NotBlank(message="The email cannot be empty")
     */
    protected $recipientEmail;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="sender_mail")
     * @Assert\Email(message="The sender email address you provided is not valid", checkMX=false)
     */
    protected $senderMail;

    /**
     * @ORM\ManyToOne(targetEntity="service")
     * @ORM\JoinColumn(name="service_code", referencedColumnName="service_id")
     */
    protected $serviceCode;

    /**
     * @ORM\Column(type="integer", name="status", nullable=false, length=1)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="authorId", referencedColumnName="id_user")
     */
    protected $author;
}