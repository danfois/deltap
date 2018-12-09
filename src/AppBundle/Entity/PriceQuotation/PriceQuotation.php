<?php

namespace AppBundle\Entity\PriceQuotation;
use AppBundle\Entity\Invoice\InvoiceDetailInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceQuotationRepository")
 * @ORM\Table(name="price_quotations")
 */
class PriceQuotation implements InvoiceDetailInterface
{
    /**
     * @ORM\Column(type="integer", name="priceQuotationId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $priceQuotationId;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotationDetail", mappedBy="priceQuotation", cascade={"all"})
     */
    protected $priceQuotationDetails;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ServiceOrder\ServiceOrder", mappedBy="priceQuotation", cascade={"persist"})
     */
    protected $serviceOrders;

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
        $priceQuotationDetail->setPriceQuotation(null);
        $this->priceQuotationDetails->removeElement($priceQuotationDetail);
    }

    public function removePriceQuotationDetailForCloning(\AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail)
    {
        $this->priceQuotationDetails->removeElement($priceQuotationDetail);
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
     * Add serviceOrder
     *
     * @param \AppBundle\Entity\ServiceOrder\ServiceOrder $serviceOrder
     *
     * @return PriceQuotation
     */
    public function addServiceOrder(\AppBundle\Entity\ServiceOrder\ServiceOrder $serviceOrder)
    {
        $this->serviceOrders[] = $serviceOrder;

        return $this;
    }

    /**
     * Remove serviceOrder
     *
     * @param \AppBundle\Entity\ServiceOrder\ServiceOrder $serviceOrder
     */
    public function removeServiceOrder(\AppBundle\Entity\ServiceOrder\ServiceOrder $serviceOrder)
    {
        $this->serviceOrders->removeElement($serviceOrder);
    }

    /**
     * Get serviceOrders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiceOrders()
    {
        return $this->serviceOrders;
    }

    public function getProductName(): string
    {
        return 'Preventivo N. ' . $this->getCode();
    }

    public function getProductCode(): string
    {
        return $this->getCode();
    }

    public function getInvoicePrice(): float
    {
        $pqd = $this->getPriceQuotationDetails();

        $sum = 0;

        foreach($pqd as $p) {
            if($p->getStatus() == PriceQuotationDetail::CONFIRMED) {
                $sum += $p->getPrice();
            }
        }

        return $sum;
    }

    public function getInvoiceVat()
    {
        $pqd = $this->getPriceQuotationDetails();

        if(count($pqd) == 0) return 0;

        $vat = $pqd[0]->getVat();

        return $vat;
    }

    public function getInvoiceCustomer()
    {
        return $this->getCustomer();
    }
}
