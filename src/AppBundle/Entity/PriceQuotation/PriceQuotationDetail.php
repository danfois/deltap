<?php

namespace AppBundle\Entity\PriceQuotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceQuotationDetailRepository")
 * @ORM\Table(name="price_quotation_details")
 */
class PriceQuotationDetail
{
    const UNCONFIRMED = 1;
    const CONFIRMED = 2;

    /**
     * @ORM\Column(type="integer", name="priceQuotationDetailId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $priceQuotationDetailId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotation", inversedBy="priceQuotationDetails", cascade={"persist"})
     * @ORM\JoinColumn(name="priceQuotationId", referencedColumnName="priceQuotationId")
     */
    protected $priceQuotation;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ServiceType")
     * @ORM\JoinColumn(name="service_type", referencedColumnName="service_id")
     * @Assert\NotBlank(message="You have to choose a service type")
     */
    protected $serviceType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service")
     * @ORM\JoinColumn(name="service", referencedColumnName="service_id")
     */
    protected $serviceCode;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="vat")
     */
    protected $vat;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="name")
     * @Assert\NotBlank(message="Price Quotation Detail name cannot be null")
     * @Assert\Length(max=64, maxMessage="Price Quotation Detail name too long. Max 64 chars")
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true, name="description")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PriceQuotation\Stage", mappedBy="priceQuotationDetail", cascade={"persist", "remove"})
     */
    protected $stages;

    /**
     * @ORM\Column(type="integer", length=1, nullable=false, name="emittedOrders")
     */
    protected $emittedOrders;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="price")
     * @Assert\NotBlank(message="Price must not be null")
     */
    protected $price;

    /**
     * @ORM\Column(type="integer", length=1, nullable=true, name="status")
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\PriceQuotation\Attachment", cascade={"persist"})
     * @ORM\JoinColumn(name="attachmentId", referencedColumnName="attachmentId", nullable=true)
     */
    protected $attachment;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get priceQuotationDetailId
     *
     * @return integer
     */
    public function getPriceQuotationDetailId()
    {
        return $this->priceQuotationDetailId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PriceQuotationDetail
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PriceQuotationDetail
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set priceQuotation
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotation $priceQuotation
     *
     * @return PriceQuotationDetail
     */
    public function setPriceQuotation(\AppBundle\Entity\PriceQuotation\PriceQuotation $priceQuotation = null)
    {
        $this->priceQuotation = $priceQuotation;

        return $this;
    }

    /**
     * Get priceQuotation
     *
     * @return \AppBundle\Entity\PriceQuotation\PriceQuotation
     */
    public function getPriceQuotation()
    {
        return $this->priceQuotation;
    }

    /**
     * Set serviceType
     *
     * @param \AppBundle\Entity\ServiceType $serviceType
     *
     * @return PriceQuotationDetail
     */
    public function setServiceType(\AppBundle\Entity\ServiceType $serviceType = null)
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    /**
     * Get serviceType
     *
     * @return \AppBundle\Entity\ServiceType
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * Set serviceCode
     *
     * @param \AppBundle\Entity\Service $serviceCode
     *
     * @return PriceQuotationDetail
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
     * Add stage
     *
     * @param \AppBundle\Entity\PriceQuotation\Stage $stage
     *
     * @return PriceQuotationDetail
     */
    public function addStage(\AppBundle\Entity\PriceQuotation\Stage $stage)
    {
        $this->stages[] = $stage;

        return $this;
    }

    /**
     * Remove stage
     *
     * @param \AppBundle\Entity\PriceQuotation\Stage $stage
     */
    public function removeStage(\AppBundle\Entity\PriceQuotation\Stage $stage)
    {
        $this->stages->removeElement($stage);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * @return mixed
     */
    public function getEmittedOrders()
    {
        return $this->emittedOrders;
    }

    /**
     * @param mixed $emittedOrders
     */
    public function setEmittedOrders($emittedOrders)
    {
        $this->emittedOrders = $emittedOrders;
    }

    /**
     * Set vat
     *
     * @param string $vat
     *
     * @return PriceQuotationDetail
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
     * Set price
     *
     * @param string $price
     *
     * @return PriceQuotationDetail
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return PriceQuotationDetail
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
     * Set attachment
     *
     * @param \AppBundle\Entity\PriceQuotation\Attachment $attachment
     *
     * @return PriceQuotationDetail
     */
    public function setAttachment(\AppBundle\Entity\PriceQuotation\Attachment $attachment = null)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return \AppBundle\Entity\PriceQuotation\Attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }
}
