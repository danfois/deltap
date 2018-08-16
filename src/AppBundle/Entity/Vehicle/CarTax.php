<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarTaxRepository")
 * @ORM\Table(name="carTax")
 */
class CarTax extends VehiclePeriodicCost
{
    /**
     * @ORM\ManyToOne(targetEntity="Vehicle", inversedBy="carTaxes")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    private $vehicle;

    /**
     * @ORM\Column(type="integer", name="carTaxId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $carTaxId;

    /**
     * Get carTaxId
     *
     * @return integer
     */
    public function getCarTaxId()
    {
        return $this->carTaxId;
    }

    public function getVehicle()
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }
}
