<?php

namespace AppBundle\Entity\PriceQuotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as MyAssert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StageRepository")
 * @ORM\Table("price_quotation_stages")
 */
class Stage
{
    /**
     * @ORM\Column(type="integer", name="stageId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $stageId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotationDetail", inversedBy="stages", cascade={"persist"})
     * @ORM\JoinColumn(name="priceQuotationDetailId", referencedColumnName="priceQuotationDetailId")
     */
    protected $priceQuotationDetail;

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
     * @ORM\Column(type="integer", length=2, nullable=false, name="bus_number")
     * @Assert\NotBlank(message="Bus Number cannot be null")
     * @Assert\Length(max=2, maxMessage="Max Bus allowed for single stage is 99")
     */
    protected $busNumber;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true, name="passengers")
     */
    protected $passengers;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="km")
     * @Assert\NotBlank(message="Estimated Km cannot be null")
     */
    protected $km;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="price")
     * @Assert\NotBlank()
     */
    protected $price;

    /**
     * @ORM\Column(type="json_array", name="repeated_times", nullable=true)
     */
    protected $repeatedTimes;

    /**
     * @ORM\Column(type="json_array", name="repeated_days", nullable=true)
     */
    protected $repeatedDays;

    /**
     * @ORM\Column(type="string", nullable=false, length=16, name="estimated_time")
     * @Assert\NotBlank(message="Estimated time for a stage cannot be null")
     */
    protected $estimatedTime;

    /**
     * @ORM\Column(type="string", nullable=true, name="leftouts")
     * @MyAssert\DateTags
     */
    protected $leftouts;

    /**
     * @ORM\Column(type="text", nullable=true, name="directionsLink")
     */
    protected $directionsLink;


    /**
     * Get stageId
     *
     * @return integer
     */
    public function getStageId()
    {
        return $this->stageId;
    }

    /**
     * Set departureLocation
     *
     * @param string $departureLocation
     *
     * @return Stage
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
     * Set departureDate
     *
     * @param \DateTime $departureDate
     *
     * @return Stage
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
     * @return Stage
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
     * Set busNumber
     *
     * @param integer $busNumber
     *
     * @return Stage
     */
    public function setBusNumber($busNumber)
    {
        $this->busNumber = $busNumber;

        return $this;
    }

    /**
     * Get busNumber
     *
     * @return integer
     */
    public function getBusNumber()
    {
        return $this->busNumber;
    }

    /**
     * Set km
     *
     * @param string $km
     *
     * @return Stage
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return string
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Stage
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
     * Set repeatedTimes
     *
     * @param array $repeatedTimes
     *
     * @return Stage
     */
    public function setRepeatedTimes($repeatedTimes)
    {
        $this->repeatedTimes = $repeatedTimes;

        return $this;
    }

    /**
     * Get repeatedTimes
     *
     * @return array
     */
    public function getRepeatedTimes()
    {
        return $this->repeatedTimes;
    }

    /**
     * Set repeatedDays
     *
     * @param array $repeatedDays
     *
     * @return Stage
     */
    public function setRepeatedDays($repeatedDays)
    {
        $this->repeatedDays = $repeatedDays;

        return $this;
    }

    /**
     * Get repeatedDays
     *
     * @return array
     */
    public function getRepeatedDays()
    {
        return $this->repeatedDays;
    }

    /**
     * Set estimatedTime
     *
     * @param string $estimatedTime
     *
     * @return Stage
     */
    public function setEstimatedTime($estimatedTime)
    {
        $this->estimatedTime = $estimatedTime;

        return $this;
    }

    /**
     * Get estimatedTime
     *
     * @return string
     */
    public function getEstimatedTime()
    {
        return $this->estimatedTime;
    }

    /**
     * Set priceQuotationDetail
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotationDetail $priceQuotationDetail
     *
     * @return Stage
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
     * Set arrivalLocation
     *
     * @param string $arrivalLocation
     *
     * @return Stage
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
     * Set passengers
     *
     * @param integer $passengers
     *
     * @return Stage
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
     * @return mixed
     */
    public function getLeftouts()
    {
        return $this->leftouts;
    }

    /**
     * @param mixed $leftouts
     */
    public function setLeftouts($leftouts)
    {
        $this->leftouts = $leftouts;
    }



    /**
     * Set directionsLink
     *
     * @param string $directionsLink
     *
     * @return Stage
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
}
