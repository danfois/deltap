<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
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

    private $quotationDetails;

    /**
     * @ORM\Column(type="string", name="quotation_code", nullable=false, unique=true, length=12)
     * @Assert\NotBlank(message="Quotation Code must not be null")
     * @Assert\Length(max=12, maxMessage="Quotation code is too long. Max 12 chars.")
     */
    private $quotationCode;

    /**
     * @ORM\Column(type="datetime", name="quotation_date", nullable=false)
     * @Assert\NotBlank(message="Quotation Date must not be empty")
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
     * @ORM\Column(type="string", length=64, nullable=false, name="receiver_mail")
     * @Assert\Email(message="The email address you provided is not valid", checkMX=false)
     * @Assert\NotBlank(message="The email cannot be empty")
     */
    private $receiver_mail;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="sender_mail")
     * @Assert\Email(message="The sender email address you provided is not valid", checkMX=false)
     */
    private $sender_mail;

    /**
     * @ORM\OneToOne(targetEntity="service")
     * @ORM\JoinColumn(name="service_code", referencedColumnName="service_id")
     */
    private $service_code;

    /**
     * @ORM\Column(type="integer", name="status", nullable=false, length=1)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id_user")
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="Letter", cascade={"persist"})
     * @ORM\JoinColumn(name="letter_id", referencedColumnName="letterId")
     */
    private $letter;

    public function __construct()
    {
        $this->quotationDetails = new ArrayCollection();
    }

    public function getQuotationDetails()
    {
        return $this->quotationDetails;
    }

    /**
     * Get quotationId
     *
     * @return integer
     */
    public function getQuotationId()
    {
        return $this->quotationId;
    }

    /**
     * Set quotationDate
     *
     * @param \DateTime $quotationDate
     *
     * @return PriceQuotation
     */
    public function setQuotationDate($quotationDate)
    {
        $this->quotation_date = $quotationDate;

        return $this;
    }

    /**
     * Get quotationDate
     *
     * @return \DateTime
     */
    public function getQuotationDate()
    {
        return $this->quotation_date;
    }

    /**
     * Set request
     *
     * @param string $request
     *
     * @return PriceQuotation
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set contract
     *
     * @param string $contract
     *
     * @return PriceQuotation
     */
    public function setContract($contract)
    {
        $this->contract = $contract;

        return $this;
    }


    /**
     * Set status
     *
     * @param integer $status
     *
     * @return PriceQuotation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return PriceQuotation
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set serviceCode
     *
     * @param \AppBundle\Entity\service $serviceCode
     *
     * @return PriceQuotation
     */
    public function setServiceCode(\AppBundle\Entity\service $serviceCode = null)
    {
        $this->service_code = $serviceCode;

        return $this;
    }

    /**
     * Get serviceCode
     *
     * @return \AppBundle\Entity\service
     */
    public function getServiceCode()
    {
        return $this->service_code;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return PriceQuotation
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set letter
     *
     * @param \AppBundle\Entity\Letter $letter
     *
     * @return PriceQuotation
     */
    public function setLetter(\AppBundle\Entity\Letter $letter = null)
    {
        $this->letter = $letter;

        return $this;
    }

    /**
     * Get letter
     *
     * @return \AppBundle\Entity\Letter
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * Set quotationCode
     *
     * @param string $quotationCode
     *
     * @return PriceQuotation
     */
    public function setQuotationCode($quotationCode)
    {
        $this->quotationCode = $quotationCode;

        return $this;
    }

    /**
     * Get quotationCode
     *
     * @return string
     */
    public function getQuotationCode()
    {
        return $this->quotationCode;
    }

    /**
     * Get contract
     *
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set receiverMail
     *
     * @param string $receiverMail
     *
     * @return PriceQuotation
     */
    public function setReceiverMail($receiverMail)
    {
        $this->receiver_mail = $receiverMail;

        return $this;
    }

    /**
     * Get receiverMail
     *
     * @return string
     */
    public function getReceiverMail()
    {
        return $this->receiver_mail;
    }

    /**
     * Set senderMail
     *
     * @param string $senderMail
     *
     * @return PriceQuotation
     */
    public function setSenderMail($senderMail)
    {
        $this->sender_mail = $senderMail;

        return $this;
    }

    /**
     * Get senderMail
     *
     * @return string
     */
    public function getSenderMail()
    {
        return $this->sender_mail;
    }
}
