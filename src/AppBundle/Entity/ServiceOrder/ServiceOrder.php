<?php


namespace AppBundle\Entity\ServiceOrder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceOrderRepository")
 * @ORM\Table(name="service_orders")
 */
class ServiceOrder
{
    //todo: implementare l'interfaccia per la fattura
    //todo: implementare la proprietà e la relazione per la fattura

    /**
     * @ORM\Column(type="integer", name="serviceOrderId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $serviceOrder;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer", inversedBy="serviceOrders")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="idCustomer")
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotation")
     * @ORM\JoinColumn(name="priceQuotationId", referencedColumnName="priceQuotationId")
     */
    protected $priceQuotation;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotationDetail")
     * @ORM\JoinColumn(name="priceQuotationDetailId", referencedColumnName="priceQuotationDetailId")
     */
    protected $priceQuotationDetail;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\Stage")
     * @ORM\JoinColumn(name="stageId", referencedColumnName("stageId")
     */
    protected $stage;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ServiceOrder\Report", mappedBy="serviceOrder")
     */
    protected $report;

    /**
     * @ORM\Column(type="string", nullable=false, length=64, name="departure_location")
     * @Assert\NotBlank(message="Departure Location cannot be null")
     * @Assert\Length(max=64, maxMessage="Departure location too long. Max 64 chars")
     */
    protected $departureLocation;

    /**
     * @ORM\Column(type="string", nullable=false, length=64, name="arrival_location")
     * @Assert\NotBlank(message="Arrival Location cannot be null")
     * @Assert\Length(max=64, maxMessage="Arrival location too long. Max 64 chars")
     */
    protected $arrivalLocation;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="departure_date")
     * @Assert\NotBlank(message="Departure Date cannot be null")
     */
    protected $departureDate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="arrival_date")
     * @Assert\NotBlank(message="Arrival Date cannot be null")
     */
    protected $arrivalDate;

    /**
     * @ORM\Column(type="text", nullable=true, name="description")
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true, name="dispositions")
     */
    protected $dispositions;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true, name="passengers")
     */
    protected $passengers;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id_user")
     */
    protected $driver;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\Vehicle")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    protected $vehicle;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="price")
     * @Assert\NotBlank()
     */
    protected $price;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ServiceType")
     * @ORM\JoinColumn(name="serviceTypeId", referencedColumnName="service_id")
     */
    protected $serviceFrequency;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service")
     * @ORM\JoinColumn(name="serviceId", referencedColumnName="service_id")
     */
    protected $service;




}