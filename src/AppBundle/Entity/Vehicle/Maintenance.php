<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaintenanceRepository")
 * @ORM\Table(name="maintenances")
 */
class Maintenance
{
    /**
     * @ORM\Column(type="integer", name="maintenanceId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $maintenanceId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\Vehicle")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    protected $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="providerId", referencedColumnName="idProvider")
     */
    protected $provider;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Employee")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    protected $employee;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="startKm")
     * @Assert\NotBlank(message="Start Km must not be nulL")
     */
    protected $startKm;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="startDate")
     * @Assert\NotBlank(message="Start Date cannot be null")
     */
    protected $startDate;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehicle\MaintenanceDetail", mappedBy="maintenance", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $maintenanceDetails;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Invoice\ReceivedInvoice")
     * @ORM\JoinColumn(name="invoiceId", referencedColumnName="invoiceId")
     */
    protected $invoice;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->maintenanceDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get maintenanceId
     *
     * @return integer
     */
    public function getMaintenanceId()
    {
        return $this->maintenanceId;
    }

    /**
     * Set startKm
     *
     * @param string $startKm
     *
     * @return Maintenance
     */
    public function setStartKm($startKm)
    {
        $this->startKm = $startKm;

        return $this;
    }

    /**
     * Get startKm
     *
     * @return string
     */
    public function getStartKm()
    {
        return $this->startKm;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Maintenance
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle $vehicle
     *
     * @return Maintenance
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
     * Set provider
     *
     * @param \AppBundle\Entity\Provider $provider
     *
     * @return Maintenance
     */
    public function setProvider(\AppBundle\Entity\Provider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \AppBundle\Entity\Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return Maintenance
     */
    public function setEmployee(\AppBundle\Entity\Employee\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\Employee\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }


    /**
     * Add maintenanceDetail
     *
     * @param \AppBundle\Entity\Vehicle\MaintenanceDetail $maintenanceDetail
     *
     * @return Maintenance
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

    /**
     * Set invoice
     *
     * @param \AppBundle\Entity\Invoice\ReceivedInvoice $invoice
     *
     * @return Maintenance
     */
    public function setInvoice(\AppBundle\Entity\Invoice\ReceivedInvoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \AppBundle\Entity\Invoice\ReceivedInvoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}
