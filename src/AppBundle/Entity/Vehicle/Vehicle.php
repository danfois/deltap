<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleRepository")
 * @ORM\Table(name="vehicles")
 */
class Vehicle
{
    //todo: inserire le relazioni con i costi creati in precedenza
    //todo: inserire nel constructor gli array collection

    /**
     * @ORM\Column(type="integer", name="vehicleId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $vehicleId;

    /**
     * @ORM\OneToMany(targetEntity="Tachograph", mappedBy="vehicle")
     */
    private $tachographs;

    /**
     * @ORM\OneToMany(targetEntity="Insurance", mappedBy="vehicle")
     */
    private $insurances;

    /**
     * @ORM\OneToMany(targetEntity="CarTax", mappedBy="vehicle")
     */
    private $carTaxes;

    /**
     * @ORM\OneToMany(targetEntity="CarReview", mappedBy="vehicle")
     */
    private $carReviews;

    /**
     * @ORM\Column(type="string", length=10, nullable=false, name="plate")
     * @Assert\NotBlank(message="Plate cannot be null)
     * @Assert\Length(max=10, maxMessage="Plate too long. Max 10 chars")
     */
    private $plate;

    /**
     * @ORM\Column(type="string", length=10, nullable=true, name="exPlate")
     * @Assert\Length(max=10, maxMessage="Ex Plate too long. Max 10 chars")
     */
    private $exPlate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="carRegistrationDate")
     * @Assert\NotBlank(message="Car Registration Date cannot be null")
     */
    private $carRegistrationDate;

    /**
     * @ORM\Column(type="string", nullable=false, length=64, name="carRegistrationNumber")
     * @Assert\NotBlank(message="Car Registration Number cannot be null")
     * @Assert\Length(max=64, maxMessage="Car Registration Number is too long. Max 64 chars")
     */
    private $carRegistrationNumber;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="registrationCardDate")
     * @Assert\NotBlank(message="Registration Card Date must not be null")
     */
    private $registrationCardDate;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="brand")
     * @Assert\NotBlank(message="Vehicle's brand cannot be null")
     * @Assert\Length(max=64, maxMessage="Brand too long. Max 64 chars")
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, name="model")
     * @Assert\NotBlank(message="Vehicle's model cannot be null")
     */
    private $model;

    /**
     * @ORM\Column(type="integer", nullable=false, length=3, name="seats")
     * @Assert\NotBlank(message="Seats cannot be null")
     * @Assert\Length(max=3, maxMessage="A Vehichle cannot have more than 999 seats")
     */
    private $seats;

    /**
     * @ORM\Column(type="integer", nullable=false, length=3, name="stands")
     * @Assert\NotBlank(message="Stands cannot be null")
     * @Assert\Length(max=3, maxMessage="A Vehichle cannot have more than 999 stands")
     */
    private $stands;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="width")
     * @Assert\NotBlank(message="Vehicle's width cannot be null")
     */
    private $width;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="length")
     * @Assert\NotBlank(message="Vehicle's length cannot be null")
     */
    private $length;

    /**
     * @ORM\Column(type="string", nullable=true, length=128, name="financing")
     */
    private $financing;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="purchaseDate")
     * @Assert\NotBlank(message="Purchase Date cannot be null")
     */
    private $purchaseDate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="saleDate")
     * @Assert\NotBlank(message="Sale Date cannot be null")
     */
    private $saleDate;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="useTypology")
     * @Assert\NotBlank(message="Use Typology cannot be null")
     */
    private $useTypology;

    /**
     * @ORM\Column(type="string", nullable=false, length=128, name="useDestination")
     * @Assert\NotBlank(message="Use Destination must not be null")
     * @Assert\Length(max=128, maxMessage="Use Destination too long. Max 128 chars")
     */
    private $useDestination;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="bodyWork")
     */
    private $bodyWork;

    /**
     * @ORM\Column(type="string", length=20, nullable=false, name="frame")
     * @Assert\NotBlank(message="Vehicle's frame cannot be null")
     * @Assert\Length(max=20, maxMessage="Vehicle's frame too long. Max 20 chars")
     */
    private $frame;

    /**
     * @ORM\Column(type="string", nullable=false, length=255, name="owner")
     * @Assert\NotBlank(message="Vehicle's Owner must not be null")
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=20, nullable=false, name="transmission")
     * @Assert\NotBlank(message="Vehicle's Transmission cannot be null")
     * @Assert\Length(max=20, maxMessage="Vehicle's Transmission is too long. Max 20 chars")
     */
    private $transmission;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="tires")
     * @Assert\Length(max=64, maxMessage="Tires field is too long. Max 64 chars")
     */
    private $tires;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="alternateTires")
     * @Assert\Length(max=64, maxMessage="Alternate Tires field is too long. Max 64 chars")
     */
    private $alternateTires;

    /**
     * @ORM\Column(type="string", length=64, nullable=true, name="regionalAuthorization")
     */
    private $regionalAuthorization;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, name="areation")
     * @Assert\NotBlank(message="Vehicle's areation cannot be null")
     */
    private $areation;

    /**
     * @ORM\Column(type="integer", length=3, nullable=false, name="passengersSeated")
     * @Assert\NotBlank(message="Seated Passengers cannot be null")
     * @Assert\Length(max=3, maxMessage="There cannot be more than 999 seated passengers")
     */
    private $passengersSeated;

    /**
     * @ORM\Column(type="integer", length=3, nullable=false, name="passengersStanding")
     * @Assert\NotBlank(message="Standing Passengers cannot be null")
     * @Assert\Length(max=3, maxMessage="There cannot be more than 999 standing passengers")
     */
    private $passengersStanding;

    /**
     * @ORM\Column(type="integer", length=1, nullable=false, name="emergencyExits")
     * @Assert\NotBlank(message="Emergency exits cannot be null")
     * @Assert\Length(max=1, maxMessage="There cannot be more than 9 emergency exits")
     */
    private $emergencyExits;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, name="engineNumber")
     * @Assert\NotBlank(message="Engine Number cannot be null")
     */
    private $engineNumber;

    /**
     * @ORM\Column(type="string", nullable=false, length=24, name="omologationNumber")
     * @Assert\NotBlank(message="Omologation Number cannot be null")
     * @Assert\Length(max=24, maxMessage="Omologation Number is too long. Max 24 chars")
     */
    private $omologationNumber;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="maximumloadMass", nullable=false)
     * @Assert\NotBlank(message="Maximum Load Mass cannot be null")
     */
    private $maximumLoadMass;

    /**
     * @ORM\Column(type="string", length=24, nullable=true, name="category")
     * @Assert\Length(message="Vehicle's category is too long. Max 24 chars allowed")
     */
    private $category;

    /**
     * @ORM\Column(type="integer", length=1, nullable=false, name="axesNumber")
     * @Assert\NotBlank(message="Axes Number cannot be null")
     * @Assert\Length(max=1, maxMessage="There cannot be more than 9 axes on a vehicle")
     */
    private $axesNumber;

    /**
     * @ORM\Column(type="integer", nullable=false, length=5, name="engineCapacity")
     * @Assert\NotBlank(message="Engine Capacity cannot be null")
     * @Assert\Length(max=5, maxMessage="Engine Capacity cannot be over 99999")
     */
    private $engineCapacity;

    /**
     * @ORM\Column(type="integer", nullable=false, length=5, name="powerKw")
     * @Assert\NotBlank(message="Power KW cannot be null")
     * @Assert\Length(max=5, maxMessage="Power KW cannot be more than 99999")
     */
    private $powerKw;

    /**
     * @ORM\Column(type="string", nullable=false, length=32, name="fuel")
     * @Assert\NotBlank(message="Fuel Type cannot be null")
     * @Assert\Length(max=32, maxMessage="Fuel cannot be longer than 32 chars")
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=128, nullable=true, name="fireExtinguisherNumber")
     */
    private $fireExtinguisherNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="fireExtinguisherExpiration")
     */
    private $fireExtinguisherExpiration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="notes")
     */
    private $notes;
}