<?php

namespace AppBundle\Entity\Vehicle;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaintenanceRelationshipRepository")
 * @ORM\Table(name="maintenance_relationships")
 */
class MaintenanceRelationship
{
    /**
     * @ORM\Column(type="integer", name="relationshipId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $relationshipId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\Vehicle", inversedBy="maintenanceRelationships")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    protected $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\MaintenanceType")
     * @ORM\JoinColumn(name="maintenanceTypeId", referencedColumnName="maintenanceTypeId")
     */
    protected $maintenanceType;

    /**
     * Get relationshipId
     *
     * @return integer
     */
    public function getRelationshipId()
    {
        return $this->relationshipId;
    }

    /**
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle $vehicle
     *
     * @return MaintenanceRelationship
     */
    public function setVehicle(\AppBundle\Entity\Vehicle\Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \AppBundle\Entity\Vehicle\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set maintenanceType
     *
     * @param \AppBundle\Entity\Vehicle\MaintenanceType $maintenanceType
     *
     * @return MaintenanceRelationship
     */
    public function setMaintenanceType(\AppBundle\Entity\Vehicle\MaintenanceType $maintenanceType = null)
    {
        $this->maintenanceType = $maintenanceType;

        return $this;
    }

    /**
     * Get maintenanceType
     *
     * @return \AppBundle\Entity\Vehicle\MaintenanceType
     */
    public function getMaintenanceType()
    {
        return $this->maintenanceType;
    }
}
