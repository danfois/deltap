<?php

namespace AppBundle\Entity\Vehicle;
use AppBundle\Entity\Invoice\InvoiceDetailInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InsuranceRepository")
 * @ORM\Table(name="insurances")
 */
class Insurance extends VehiclePeriodicCost implements InvoiceDetailInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Vehicle", inversedBy="insurances")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    private $vehicle;

    /**
     * @ORM\Column(type="integer", name="insuranceId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $insuranceId;

    /**
     * @ORM\OneToMany(targetEntity="InsuranceSuspension", mappedBy="insurance")
     */
    private $suspensions;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="companyId", referencedColumnName="idProvider")
     */
    private $company;

    /**
     * @ORM\Column(type="string", nullable=false, length=64, name="number")
     * @Assert\NotBlank(message="Insurance Number cannot be null")
     * @Assert\Length(max=64, maxMessage="Insurance Number too long. Max 64 chars")
     */
    private $number;

    /**
     * @ORM\Column(type="string", nullable=true, length=128, name="agent")
     */
    private $agent;

    /**
     * @ORM\Column(type="integer", nullable=false, length=1, name="durationType")
     * @Assert\NotBlank(message="Insurance Duration Type cannot be null")
     */
    private $durationType;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, name="flat")
     */
    private $flat;

    /**
     * @return mixed
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle $vehicle
     * @return $this
     */
    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Insurance
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set agent
     *
     * @param string $agent
     *
     * @return Insurance
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set durationType
     *
     * @param \int $durationType
     *
     * @return Insurance
     */
    public function setDurationType(int $durationType)
    {
        $this->durationType = $durationType;

        return $this;
    }

    /**
     * Get durationType
     *
     * @return \int
     */
    public function getDurationType()
    {
        return $this->durationType;
    }

    /**
     * Set flat
     *
     * @param string $flat
     *
     * @return Insurance
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;

        return $this;
    }

    /**
     * Get flat
     *
     * @return string
     */
    public function getFlat()
    {
        return $this->flat;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Provider $company
     *
     * @return Insurance
     */
    public function setCompany(\AppBundle\Entity\Provider $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Vehicle\Provider
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Get insuranceId
     *
     * @return integer
     */
    public function getInsuranceId()
    {
        return $this->insuranceId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->suspensions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add suspension
     *
     * @param \AppBundle\Entity\Vehicle\InsuranceSuspension $suspension
     *
     * @return Insurance
     */
    public function addSuspension(\AppBundle\Entity\Vehicle\InsuranceSuspension $suspension)
    {
        $this->suspensions[] = $suspension;

        return $this;
    }

    /**
     * Remove suspension
     *
     * @param \AppBundle\Entity\Vehicle\InsuranceSuspension $suspension
     */
    public function removeSuspension(\AppBundle\Entity\Vehicle\InsuranceSuspension $suspension)
    {
        $this->suspensions->removeElement($suspension);
    }

    /**
     * Get suspensions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuspensions()
    {
        return $this->suspensions;
    }

    public function getProductCode(): string
    {
        return '';
    }

    public function getProductName(): string
    {
        return 'Assicurazione Veicolo ' . $this->getVehicle()->getPlate();
    }

    public function getInvoicePrice(): float
    {
        return $this->getPrice();
    }

    public function getInvoiceVat()
    {
        return 22;
    }
}
