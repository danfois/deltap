<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

abstract class VehiclePeriodicCost
{
    /**
     * @ORM\ManyToOne(targetEntity="Vehicle")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    private $vehicle;

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
     * @ORM\Column(type="decimal", precision=10, scale=2, name="price")
     * @Assert\NotBlank(message="Price must not be null")
     */
    private $price;

    public function getVehicle() : Vehicle
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

    public function setStartDate(\DateTime $date)
    {
        $this->startDate = $date;
    }

    public function setEndDate(\DateTime $date)
    {
        $this->endDate = $date;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

}