<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @MappedSuperClass
 */
abstract class VehiclePeriodicCost
{
    /**
     * @ORM\Column(type="datetime", nullable=false, name="startDate")
     * @Assert\NotBlank(message="Start Date must not be null")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="endDate")
     * @Assert\NotBlank(message="End Date must not be null")
     */
    private $endDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="price")
     * @Assert\NotBlank(message="Price must not be null")
     */
    private $price;

    public function getVehicle()
    {
        return $this->vehicle;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function setStartDate($date)
    {
        $this->startDate = $date;
        return $this;
    }

    public function setEndDate($date)
    {
        $this->endDate = $date;
        return $this;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

}