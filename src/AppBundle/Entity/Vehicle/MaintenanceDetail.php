<?php

namespace AppBundle\Entity\Vehicle;
use AppBundle\Entity\Invoice\InvoiceDetailInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaintenanceDetailRepository")
 * @ORM\Table(name="maintenance_details")
 */
class MaintenanceDetail implements InvoiceDetailInterface
{
    /**
     * @ORM\Column(type="integer", name="maintenanceDetailId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $maintenanceDetailId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\Maintenance", inversedBy="maintenanceDetails")
     * @ORM\JoinColumn(name="maintenanceId", referencedColumnName="maintenanceId")
     */
    protected $maintenance;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle\MaintenanceType", inversedBy="maintenanceDetails")
     * @ORM\JoinColumn(name="maintenanceTypeId", referencedColumnName="maintenanceTypeId")
     */
    protected $maintenanceType;

    /**
     * @ORM\Column(type="string", nullable=false, name="description")
     * @Assert\NotBlank(message="Maintenance Detail description cannot be null")
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="amount")
     * @Assert\NotBlank(message="Maintenance Detail amount cannot be nulL")
     */
    protected $amount;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false, name="vat")
     * @Assert\NotBlank(message="Maintenance Detail VAT percentage cannot be null")
     * @Assert\Length(max=2, maxMessage="Vat percentage cannot be higher than 99%")
     */
    protected $vat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="totalAmount")
     */
    protected $totalAmount;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="expirationDate")
     */
    protected $expirationDate;

    /**
     * @ORM\Column(type="integer", nullable=true, name="expirationKm")
     */
    protected $expirationKm;

    /**
     * Get maintenanceDetailId
     *
     * @return integer
     */
    public function getMaintenanceDetailId()
    {
        return $this->maintenanceDetailId;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MaintenanceDetail
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return MaintenanceDetail
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set vat
     *
     * @param integer $vat
     *
     * @return MaintenanceDetail
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return integer
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set totalAmount
     *
     * @param string $totalAmount
     *
     * @return MaintenanceDetail
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return string
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set maintenance
     *
     * @param \AppBundle\Entity\Vehicle\Maintenance $maintenance
     *
     * @return MaintenanceDetail
     */
    public function setMaintenance(\AppBundle\Entity\Vehicle\Maintenance $maintenance = null)
    {
        $this->maintenance = $maintenance;

        return $this;
    }

    /**
     * Get maintenance
     *
     * @return \AppBundle\Entity\Vehicle\Maintenance
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }

    /**
     * Set maintenanceType
     *
     * @param \AppBundle\Entity\Vehicle\MaintenanceType $maintenanceType
     *
     * @return MaintenanceDetail
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

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return MaintenanceDetail
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set expirationKm
     *
     * @param integer $expirationKm
     *
     * @return MaintenanceDetail
     */
    public function setExpirationKm($expirationKm)
    {
        $this->expirationKm = $expirationKm;

        return $this;
    }

    /**
     * Get expirationKm
     *
     * @return integer
     */
    public function getExpirationKm()
    {
        return $this->expirationKm;
    }

    /*
     * Start of InvoiceDetailInterface
     */

    public function getInvoiceVat()
    {
        return $this->getVat();
    }

    public function getProductCode(): string
    {
        return '000';
    }

    public function getProductName(): string
    {
        return $this->getDescription();
    }

    public function getInvoicePrice(): float
    {
        return $this->getAmount();
    }

    public function getParentProvider()
    {
        return $this->getMaintenance()->getProvider();
    }

    /*
     * End of InvoiceDetailInterface
     */
}
