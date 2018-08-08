<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="carTax")
 */
class CarTax extends VehiclePeriodicCost
{
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
}
