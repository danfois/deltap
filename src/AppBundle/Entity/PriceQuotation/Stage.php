<?php

namespace AppBundle\Entity\PriceQuotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotationDetail", inversedBy="stages")
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
     * @ORM\Column(type="string", nullable=false, length=64, name="arrival")
     * @Assert\NotBlank(message="Arrival Location cannot be null")
     * @Assert\Length(max=64, maxMessage="Arrival location too long. Max 64 chars")
     */
    protected $departureArrival;

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
}