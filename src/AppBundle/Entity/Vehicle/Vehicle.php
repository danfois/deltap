<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Vehicle
{
    //todo: inserire le relazioni con i costi creati in precedenza

    private $vehicleId;

    private $tachographs;

    private $insurances;

    private $carTaxes;

    private $carReviews;

    private $plate;

    private $exPlate;

    private $carRegistrationDate;

    private $carRegistrationNumber;

    private $registrationCardDate;

    private $brand;

    private $model;

    private $seats;

    private $stands;

    private $width;

    private $length;

    private $financing;

    private $purchaseDate;

    private $saleDate;

    private $useTypology;

    private $useDestination;

    private $bodyWork;

    private $frame;

    private $owner;

    private $transmission;

    private $tires;

    private $alternateTires;

    private $regionalAuthorization;

    private $areation;

    private $passengersSeated;

    private $passengersStanding;

    private $emergencyExits;

    private $engineNumber;

    private $omologationNumber;

    private $maximumLoadMass;

    private $category;

    private $axesNumber;

    private $engineCapacity;

    private $powerKw;

    private $fuel;

    private $fireExtinguisherNumber;

    private $fireExtinguisherExpiration;

    private $notes;
}