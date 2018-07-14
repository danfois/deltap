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
}