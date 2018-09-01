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
    /**
     * @ORM\Column(type="integer", name="priceQuotationDetailId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $priceQuotationDetailId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotation", inversedBy="priceQuotationDetails")
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
     * @ORM\Column(type="string", length=64, nullable=false, name="name")
     * @Assert\NotBlank(message="Price Quotation Detail name cannot be null")
     * @Assert\Length(max=64, maxMessage=Price Quotation Detail name too long. Max 64 chars)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable="true", name="description")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PriceQuotation\Stages", mappedBy="priceQuotationDetail")
     */
    protected $stages;
}