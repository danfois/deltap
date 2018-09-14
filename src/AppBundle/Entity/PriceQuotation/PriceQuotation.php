<?php

namespace AppBundle\Entity\PriceQuotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotationDetail", mappedBy="priceQuotation", cascade={"remove"}, orphanRemoval=true)
     */
    protected $priceQuotationDetails;

    /**
     * @ORM\Column(type="string", length=12, nullable=false, name="code")
     * @Assert\NotBlank(message="Price Quotation Code cannot be null")
     * @Assert\Length(max=12, maxMessage="Price Quotation Code is too long. Max 12 chars")
     */
    protected $code;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="priceQuotationDate")
     * @Assert\NotBlank(message="Price Quotation Date cannot be null")
     */
    protected $priceQuotationDate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="idCustomer")
     */
    protected $customer;

    /**
     * @ORM\Column(type="string", nullable=true, name="contract")
     */
    protected $contract;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Letter", cascade={"persist"})
     * @ORM\JoinColumn(name="letterId", referencedColumnName="letterId", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service")
     * @ORM\JoinColumn(name="service_code", referencedColumnName="service_id")
     */
    protected $serviceCode;

    /**
     * @ORM\Column(type="integer", name="status", nullable=false, length=1)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="authorId", referencedColumnName="id_user")
     */
    protected $author;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->priceQuotationDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get priceQuotationId
     *
     * @return integer
     */
    public function getPriceQuotationId()
    {
        return $this->priceQuotationId;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return PriceQuotation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set priceQuotationDate
     *
     * @param string $priceQuotationDate
     *
     * @return PriceQuotation
     */
    public function setPriceQuotationDate($priceQuotationDate)
    {
        $this->priceQuotationDate = $priceQuotationDate;

        return $this;
    }

    /**
     * Get priceQuotationDate
     *
     * @return string
     */
    public function getPriceQuotationDate()
    {
        return $this->priceQuotationDate;
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
     * Get contract
     *
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
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
     * Set recipientEmail
     *
     * @param string $recipientEmail
     *
     * @return PriceQuotation
     */
    public function setRecipientEmail($recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;

        return $this;
    }

    /**
     * Get recipientEmail
     *
     * @return string
     */
    public function getRecipientEmail()
    {
        return $this->recipientEmail;
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
        $this->senderMail = $senderMail;

        return $this;
    }

    /**
     * Get senderMail
     *
     * @return string
     */
    public function getSenderMail()
    {
        return $this->senderMail;
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
     * Add priceQuotationDetail
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail
     *
     * @return PriceQuotation
     */
    public function addPriceQuotationDetail(\AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail)
    {
        $this->priceQuotationDetails[] = $priceQuotationDetail;

        return $this;
    }

    /**
     * Remove priceQuotationDetail
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail
     */
    public function removePriceQuotationDetail(\AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail)
    {
        $this->priceQuotationDetails->removeElement($priceQuotationDetail);
        $priceQuotationDetail->setPriceQuotation(null);
    }

    /**
     * Get priceQuotationDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPriceQuotationDetails()
    {
        return $this->priceQuotationDetails;
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
     * Set serviceCode
     *
     * @param \AppBundle\Entity\Service $serviceCode
     *
     * @return PriceQuotation
     */
    public function setServiceCode(\AppBundle\Entity\Service $serviceCode = null)
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    /**
     * Get serviceCode
     *
     * @return \AppBundle\Entity\Service
     */
    public function getServiceCode()
    {
        return $this->serviceCode;
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
}
