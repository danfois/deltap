<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InsuranceVehicleAssociationRepository")
 * @ORM\Table(name="insurance_vehicle_associations")
 */
class InsuranceVehicleAssociation {
    /**
     * @ORM\Column(type="integer", name="associationId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $associationId;

    /**
     * @ORM\ManyToOne(targetEntity="Vehicle", inversedBy="insuranceAssociations")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    protected $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity="Insurance", inversedBy="vehicleAssociations")
     * @ORM\JoinColumn(name="insuranceId", referencedColumnName="insuranceId")
     */
    protected $insurance;

    /**
     * Get associationId.
     *
     * @return int
     */
    public function getAssociationId()
    {
        return $this->associationId;
    }

    /**
     * Set vehicle.
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle|null $vehicle
     *
     * @return InsuranceVehicleAssociation
     */
    public function setVehicle(\AppBundle\Entity\Vehicle\Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle.
     *
     * @return \AppBundle\Entity\Vehicle\Vehicle|null
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set insurance.
     *
     * @param \AppBundle\Entity\Vehicle\Insurance|null $insurance
     *
     * @return InsuranceVehicleAssociation
     */
    public function setInsurance(\AppBundle\Entity\Vehicle\Insurance $insurance = null)
    {
        $this->insurance = $insurance;

        return $this;
    }

    /**
     * Get insurance.
     *
     * @return \AppBundle\Entity\Vehicle\Insurance|null
     */
    public function getInsurance()
    {
        return $this->insurance;
    }
}
