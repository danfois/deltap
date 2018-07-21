<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceQuotationDetailRepository")
 * @ORM\Table(name="price_quotation_details")
 */
class PriceQuotationDetail
{
    /**
     * @ORM\Column(type="integer", name="detail_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $detail_id;

    /**
     * @ORM\ManyToOne(targetEntity="PriceQuotation")
     * @ORM\JoinColumn(name="price_quotation", referencedColumnName="quotationId")
     */
    private $price_quotation;

    /**
     * @ORM\Column(type="string", nullable=false, length=120, name="departure")
     * @Assert\NotBlank(message="You have to provide a departure place")
     * @Assert\Length(max=120, maxMessage="Departure place cannot exceed 120 chars")
     */
    private $departure;

    /**
     * @ORM\Column(type="string", nullable=false, length=120, name="arrival")
     * @Assert\NotBlank(message="You have to provide a arrival place")
     * @Assert\Length(max=120, maxMessage="Arrival place cannot exceed 120 chars")
     */
    private $arrival;

    /**
     * @ORM\Column(type="text", nullable=true, name="description")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="departure_date")
     * @Assert\NotBlank(message="You have to provide a valid departure date")
     */
    private $departure_date;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="arrival_date")
     * @Assert\NotBlank(message="You have to provide a valid arrival date")
     */
    private $arrival_date;

    /**
     * @ORM\Column(type="json_array", name="repeated_times", nullable=true)
     */
    private $array_repeated_times;

    /**
     * @ORM\Column(type="json_array", name="repeated_days", nullable=true)
     */
    private $array_repeated_days;

    /**
     * @ORM\Column(type="integer", length=2, name="bus_number", nullable=false)
     * @Assert\NotBlank(message="You have to provide a valid bus number")
     * @Assert\Length(max=2, maxMessage="Bus number can't be higher than 99")
     */
    private $bus_number;

    /**
     * @ORM\Column(type="integer", length=4, name="passengers", nullable=false)
     * @Assert\NotBlank(message="You have to provide a valid number of passengers")
     * @Assert\Length(max=4, maxMessage="Passengers cannot be more than 9999")
     */
    private $passengers;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $estimated_km;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $estimated_time;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="price")
     * @Assert\NotBlank(message="You have to provide a valid price for the Price Quotation Detail")
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=2, scale=2, nullable=true, name="vat")
     * @Assert\Range(min=0, max=99, maxMessage="Vat percentage can't be higher than 99%")
     */
    private $vat;

    /**
     * @ORM\Column(type="integer", length=1, nullable=false, name="status")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=16, nullable=false, name="vat_type")
     */
    private $vat_type;

    /**
     * @ORM\OneToOne(targetEntity="ServiceType")
     * @ORM\JoinColumn(name="service_type", referencedColumnName="service_id")
     * @Assert\NotBlank(message="You have to choose a service type")
     */
    private $service_type;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true, name="service_code")
     */
    private $service_code;

    /**
     * Get detailId
     *
     * @return integer
     */
    public function getDetailId()
    {
        return $this->detail_id;
    }

    /**
     * Set departure
     *
     * @param string $departure
     *
     * @return PriceQuotationDetail
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return string
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set arrival
     *
     * @param string $arrival
     *
     * @return PriceQuotationDetail
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return string
     */
    public function getArrival()
    {
        return $this->arrival;
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
     * Set departureDate
     *
     * @param \DateTime $departureDate
     *
     * @return PriceQuotationDetail
     */
    public function setDepartureDate($departureDate)
    {
        $this->departure_date = $departureDate;

        return $this;
    }

    /**
     * Get departureDate
     *
     * @return \DateTime
     */
    public function getDepartureDate()
    {
        return $this->departure_date;
    }

    /**
     * Set arrivalDate
     *
     * @param \DateTime $arrivalDate
     *
     * @return PriceQuotationDetail
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrival_date = $arrivalDate;

        return $this;
    }

    /**
     * Get arrivalDate
     *
     * @return \DateTime
     */
    public function getArrivalDate()
    {
        return $this->arrival_date;
    }

    /**
     * Set arrayRepeatedTimes
     *
     * @param array $arrayRepeatedTimes
     *
     * @return PriceQuotationDetail
     */
    public function setArrayRepeatedTimes($arrayRepeatedTimes)
    {
        $this->array_repeated_times = $arrayRepeatedTimes;

        return $this;
    }

    /**
     * Get arrayRepeatedTimes
     *
     * @return array
     */
    public function getArrayRepeatedTimes()
    {
        return $this->array_repeated_times;
    }

    /**
     * Set arrayRepeatedDays
     *
     * @param array $arrayRepeatedDays
     *
     * @return PriceQuotationDetail
     */
    public function setArrayRepeatedDays($arrayRepeatedDays)
    {
        $this->array_repeated_days = $arrayRepeatedDays;

        return $this;
    }

    /**
     * Get arrayRepeatedDays
     *
     * @return array
     */
    public function getArrayRepeatedDays()
    {
        return $this->array_repeated_days;
    }

    /**
     * Set busNumber
     *
     * @param integer $busNumber
     *
     * @return PriceQuotationDetail
     */
    public function setBusNumber($busNumber)
    {
        $this->bus_number = $busNumber;

        return $this;
    }

    /**
     * Get busNumber
     *
     * @return integer
     */
    public function getBusNumber()
    {
        return $this->bus_number;
    }

    /**
     * Set passengers
     *
     * @param integer $passengers
     *
     * @return PriceQuotationDetail
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
     * Set estimatedKm
     *
     * @param string $estimatedKm
     *
     * @return PriceQuotationDetail
     */
    public function setEstimatedKm($estimatedKm)
    {
        $this->estimated_km = $estimatedKm;

        return $this;
    }

    /**
     * Get estimatedKm
     *
     * @return string
     */
    public function getEstimatedKm()
    {
        return $this->estimated_km;
    }

    /**
     * Set estimatedTime
     *
     * @param string $estimatedTime
     *
     * @return PriceQuotationDetail
     */
    public function setEstimatedTime($estimatedTime)
    {
        $this->estimated_time = $estimatedTime;

        return $this;
    }

    /**
     * Get estimatedTime
     *
     * @return string
     */
    public function getEstimatedTime()
    {
        return $this->estimated_time;
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
     * Set vatType
     *
     * @param string $vatType
     *
     * @return PriceQuotationDetail
     */
    public function setVatType($vatType)
    {
        $this->vat_type = $vatType;

        return $this;
    }

    /**
     * Get vatType
     *
     * @return string
     */
    public function getVatType()
    {
        return $this->vat_type;
    }

    /**
     * Set serviceCode
     *
     * @param integer $serviceCode
     *
     * @return PriceQuotationDetail
     */
    public function setServiceCode($serviceCode)
    {
        $this->service_code = $serviceCode;

        return $this;
    }

    /**
     * Get serviceCode
     *
     * @return integer
     */
    public function getServiceCode()
    {
        return $this->service_code;
    }

    /**
     * Set priceQuotation
     *
     * @param \AppBundle\Entity\PriceQuotation $priceQuotation
     *
     * @return PriceQuotationDetail
     */
    public function setPriceQuotation(\AppBundle\Entity\PriceQuotation $priceQuotation = null)
    {
        $this->price_quotation = $priceQuotation;

        return $this;
    }

    /**
     * Get priceQuotation
     *
     * @return \AppBundle\Entity\PriceQuotation
     */
    public function getPriceQuotation()
    {
        return $this->price_quotation;
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
        $this->service_type = $serviceType;

        return $this;
    }

    /**
     * Get serviceType
     *
     * @return \AppBundle\Entity\ServiceType
     */
    public function getServiceType()
    {
        return $this->service_type;
    }
}
