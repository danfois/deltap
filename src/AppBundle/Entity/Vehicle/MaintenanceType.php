<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaintenanceTypeRepository")
 * @ORM\Table(name="maintenance_types")
 */
class MaintenanceType
{
    /**
     * @ORM\Column(type="integer", name="maintenanceTypeId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $maintenanceTypeId;

    /**
     * @ORM\Column(type="string", nullable=false, name="maintenanceName")
     * @Assert\NotBlank(message="Maintenance Name cannot be null")
     */
    protected $maintenanceName;

    /**
     * @ORM\Column(type="string", nullable=true, name="dateInterval")
     */
    protected $dateInterval;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, name="kmInterval")
     */
    protected $kmInterval;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehicle\MaintenanceDetail", mappedBy="maintenanceType")
     */
    protected $maintenanceDetails;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->maintenanceDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get maintenanceTypeId
     *
     * @return integer
     */
    public function getMaintenanceTypeId()
    {
        return $this->maintenanceTypeId;
    }

    /**
     * Set maintenanceName
     *
     * @param string $maintenanceName
     *
     * @return MaintenanceType
     */
    public function setMaintenanceName($maintenanceName)
    {
        $this->maintenanceName = $maintenanceName;

        return $this;
    }

    /**
     * Get maintenanceName
     *
     * @return string
     */
    public function getMaintenanceName()
    {
        return $this->maintenanceName;
    }

    /**
     * Set dateInterval
     *
     * @param string $dateInterval
     *
     * @return MaintenanceType
     */
    public function setDateInterval($dateInterval)
    {
        $this->dateInterval = $dateInterval;

        return $this;
    }

    /**
     * Get dateInterval
     *
     * @return string
     */
    public function getDateInterval()
    {
        return $this->dateInterval;
    }

    /**
     * Set kmInterval
     *
     * @param string $kmInterval
     *
     * @return MaintenanceType
     */
    public function setKmInterval($kmInterval)
    {
        $this->kmInterval = $kmInterval;

        return $this;
    }

    /**
     * Get kmInterval
     *
     * @return string
     */
    public function getKmInterval()
    {
        return $this->kmInterval;
    }

    /**
     * Add maintenanceDetail
     *
     * @param \AppBundle\Entity\Vehicle\MaintenanceDetail $maintenanceDetail
     *
     * @return MaintenanceType
     */
    public function addMaintenanceDetail(\AppBundle\Entity\Vehicle\MaintenanceDetail $maintenanceDetail)
    {
        $this->maintenanceDetails[] = $maintenanceDetail;

        return $this;
    }

    /**
     * Remove maintenanceDetail
     *
     * @param \AppBundle\Entity\Vehicle\MaintenanceDetail $maintenanceDetail
     */
    public function removeMaintenanceDetail(\AppBundle\Entity\Vehicle\MaintenanceDetail $maintenanceDetail)
    {
        $this->maintenanceDetails->removeElement($maintenanceDetail);
    }

    /**
     * Get maintenanceDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMaintenanceDetails()
    {
        return $this->maintenanceDetails;
    }
}
