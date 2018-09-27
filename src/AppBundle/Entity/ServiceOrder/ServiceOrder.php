<?php


namespace AppBundle\Entity\ServiceOrder;

use AppBundle\Entity\Invoice\InvoiceDetailInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceOrderRepository")
 * @ORM\Table(name="service_orders")
 */
class ServiceOrder implements InvoiceDetailInterface
{
    /**
     * @ORM\Column(type="integer", name="serviceOrderId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $serviceOrder;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
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
     * @ORM\JoinColumn(name="stageId", referencedColumnName="stageId")
     */
    protected $stage;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ServiceOrder\Report", mappedBy="serviceOrder")
     */
    protected $report;

    /**
     * @ORM\Column(type="decimal", precision=2, scale=2, nullable=false, name="vat")
     */
    protected $vat;

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
     * @ORM\Column(type="string", nullable=false, length=6, name="startTime")
     * @Assert\NotBlank()
     */
    protected $startTime;

    /**
     * @ORM\Column(type="string", nullable=false, length=6, name="endTime")
     * @Assert\NotBlank()
     */
    protected $endTime;

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
     * @ORM\JoinColumn(name="userId", referencedColumnName="id_user", nullable=true)
     */
    protected $driver;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\Vehicle")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId", nullable=true)
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

    /**
     * @ORM\Column(type="integer", length=1, nullable=false, name="status")
     */
    protected $status;

    /**
     * @ORM\Column(type="text", nullable=true, name="directionsLink")
     */
    protected $directionsLink;




    /**
     * Get serviceOrder
     *
     * @return integer
     */
    public function getServiceOrder()
    {
        return $this->serviceOrder;
    }

    /**
     * Set departureLocation
     *
     * @param string $departureLocation
     *
     * @return ServiceOrder
     */
    public function setDepartureLocation($departureLocation)
    {
        $this->departureLocation = $departureLocation;

        return $this;
    }

    /**
     * Get departureLocation
     *
     * @return string
     */
    public function getDepartureLocation()
    {
        return $this->departureLocation;
    }

    /**
     * Set arrivalLocation
     *
     * @param string $arrivalLocation
     *
     * @return ServiceOrder
     */
    public function setArrivalLocation($arrivalLocation)
    {
        $this->arrivalLocation = $arrivalLocation;

        return $this;
    }

    /**
     * Get arrivalLocation
     *
     * @return string
     */
    public function getArrivalLocation()
    {
        return $this->arrivalLocation;
    }

    /**
     * Set departureDate
     *
     * @param \DateTime $departureDate
     *
     * @return ServiceOrder
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * Get departureDate
     *
     * @return \DateTime
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Set arrivalDate
     *
     * @param \DateTime $arrivalDate
     *
     * @return ServiceOrder
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    /**
     * Get arrivalDate
     *
     * @return \DateTime
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ServiceOrder
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
     * Set dispositions
     *
     * @param string $dispositions
     *
     * @return ServiceOrder
     */
    public function setDispositions($dispositions)
    {
        $this->dispositions = $dispositions;

        return $this;
    }

    /**
     * Get dispositions
     *
     * @return string
     */
    public function getDispositions()
    {
        return $this->dispositions;
    }

    /**
     * Set passengers
     *
     * @param integer $passengers
     *
     * @return ServiceOrder
     */
    public function setPassengers($passengers)
    {
        $this->passengers = $passengers;

        return $this;
    }

    /**
     * Get passengers
     *
     * @return integer
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return ServiceOrder
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
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return ServiceOrder
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
     * Set priceQuotation
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotation $priceQuotation
     *
     * @return ServiceOrder
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
     * Set priceQuotationDetail
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail
     *
     * @return ServiceOrder
     */
    public function setPriceQuotationDetail(\AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail = null)
    {
        $this->priceQuotationDetail = $priceQuotationDetail;

        return $this;
    }

    /**
     * Get priceQuotationDetail
     *
     * @return \AppBundle\Entity\PriceQuotation\PriceQuotationDetail
     */
    public function getPriceQuotationDetail()
    {
        return $this->priceQuotationDetail;
    }

    /**
     * Set stage
     *
     * @param \AppBundle\Entity\PriceQuotation\Stage $stage
     *
     * @return ServiceOrder
     */
    public function setStage(\AppBundle\Entity\PriceQuotation\Stage $stage = null)
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * Get stage
     *
     * @return \AppBundle\Entity\PriceQuotation\Stage
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set report
     *
     * @param \AppBundle\Entity\ServiceOrder\Report $report
     *
     * @return ServiceOrder
     */
    public function setReport(\AppBundle\Entity\ServiceOrder\Report $report = null)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return \AppBundle\Entity\ServiceOrder\Report
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Set driver
     *
     * @param \AppBundle\Entity\User $driver
     *
     * @return ServiceOrder
     */
    public function setDriver(\AppBundle\Entity\User $driver = null)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get driver
     *
     * @return \AppBundle\Entity\User
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle $vehicle
     *
     * @return ServiceOrder
     */
    public function setVehicle(\AppBundle\Entity\Vehicle\Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \AppBundle\Entity\Vehicle\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set serviceFrequency
     *
     * @param \AppBundle\Entity\ServiceType $serviceFrequency
     *
     * @return ServiceOrder
     */
    public function setServiceFrequency(\AppBundle\Entity\ServiceType $serviceFrequency = null)
    {
        $this->serviceFrequency = $serviceFrequency;

        return $this;
    }

    /**
     * Get serviceFrequency
     *
     * @return \AppBundle\Entity\ServiceType
     */
    public function getServiceFrequency()
    {
        return $this->serviceFrequency;
    }

    /**
     * Set service
     *
     * @param \AppBundle\Entity\Service $service
     *
     * @return ServiceOrder
     */
    public function setService(\AppBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \AppBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set startTime
     *
     * @param string $startTime
     *
     * @return ServiceOrder
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return string
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param string $endTime
     *
     * @return ServiceOrder
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return string
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }



    /**
     * Set directionsLink
     *
     * @param string $directionsLink
     *
     * @return ServiceOrder
     */
    public function setDirectionsLink($directionsLink)
    {
        $this->directionsLink = $directionsLink;

        return $this;
    }

    /**
     * Get directionsLink
     *
     * @return string
     */
    public function getDirectionsLink()
    {
        return $this->directionsLink;
    }

    /**
     * Set vat
     *
     * @param string $vat
     *
     * @return ServiceOrder
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

    public function getInvoicePrice(): float
    {
        return $this->getPrice();
    }

    public function getInvoiceVat()
    {
        return $this->getVat();
    }

    public function getProductCode(): string
    {
        return $this->getPriceQuotation()->getCode();
    }

    public function getProductName(): string
    {
        return $this->getDepartureDate()->format('d/m/Y') . ' - Ordine di Servizio n. ' . $this->getServiceOrder() . ' da ' . $this->getDepartureLocation() . ' a ' . $this->getArrivalLocation();
    }

}
