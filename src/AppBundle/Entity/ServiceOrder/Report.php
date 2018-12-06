<?php

namespace AppBundle\Entity\ServiceOrder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReportRepository")
 * @ORM\Table(name="reports")
 */
class Report
{
    /**
     * @ORM\Column(type="integer", name="reportId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $reportId;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ServiceOrder\ServiceOrder", inversedBy="report")
     * @ORM\JoinColumn(name="serviceOrderId", referencedColumnName="serviceOrderId")
     */
    protected $serviceOrder;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id_user")
     */
    protected $user;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="startKm")
     * @Assert\NotBlank(message="Non hai segnalato i chilometri di partenza")
     * @Assert\Length(max=10, maxMessage="I chilometri di partenza sono eccessivi")
     */
    protected $startKm;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="endKm")
     * @Assert\NotBlank(message="Non hai segnalato i chilometri di arrivo")
     * @Assert\Length(max=10, maxMessage="I chilometri di arrivo sono eccessivi")
     */
    protected $endKm;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="totalKm")
     * @Assert\NotBlank(message="Non hai segnalato i chilometri totali")
     * @Assert\Length(max=10, maxMessage="I chilometri totali sono eccessivi")
     */
    protected $totalKm;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, name="fuelLt")
     * @Assert\Length(max=10, maxMessage="Il numero dei litri di carburante è troppo alto")
     */
    protected $fuelLt;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, name="fuelCost")
     * @Assert\Length(max=10, maxMessage="Il costo del carburante è troppo elevato.")
     */
    protected $fuelCost;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, name="oilLt")
     * @Assert\Length(max=10, maxMessage="I litri d'olio inseriti sono eccessivi")
     */
    protected $oilLt;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, name="oilCost")
     * @Assert\Length(max=10, maxMessage="Il costo dell'olio è eccessivo")
     */
    protected $oilCost;

    /**
     * @ORM\Column(type="text", nullable=true, name="notes")
     */
    protected $notes;

    /**
     * @ORM\Column(type="integer", nullable=false, length=1, name="validated")
     */
    protected $validated;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="submitDate")
     */
    protected $submitDate;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="editDate")
     */
    protected $editDate;

    /**
     * Get reportId
     *
     * @return integer
     */
    public function getReportId()
    {
        return $this->reportId;
    }

    /**
     * Set startKm
     *
     * @param string $startKm
     *
     * @return Report
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
     * Set endKm
     *
     * @param string $endKm
     *
     * @return Report
     */
    public function setEndKm($endKm)
    {
        $this->endKm = $endKm;

        return $this;
    }

    /**
     * Get endKm
     *
     * @return string
     */
    public function getEndKm()
    {
        return $this->endKm;
    }

    /**
     * Set totalKm
     *
     * @param string $totalKm
     *
     * @return Report
     */
    public function setTotalKm($totalKm)
    {
        $this->totalKm = $totalKm;

        return $this;
    }

    /**
     * Get totalKm
     *
     * @return string
     */
    public function getTotalKm()
    {
        return $this->totalKm;
    }

    /**
     * Set fuelLt
     *
     * @param string $fuelLt
     *
     * @return Report
     */
    public function setFuelLt($fuelLt)
    {
        $this->fuelLt = $fuelLt;

        return $this;
    }

    /**
     * Get fuelLt
     *
     * @return string
     */
    public function getFuelLt()
    {
        return $this->fuelLt;
    }

    /**
     * Set fuelCost
     *
     * @param string $fuelCost
     *
     * @return Report
     */
    public function setFuelCost($fuelCost)
    {
        $this->fuelCost = $fuelCost;

        return $this;
    }

    /**
     * Get fuelCost
     *
     * @return string
     */
    public function getFuelCost()
    {
        return $this->fuelCost;
    }

    /**
     * Set oilLt
     *
     * @param string $oilLt
     *
     * @return Report
     */
    public function setOilLt($oilLt)
    {
        $this->oilLt = $oilLt;

        return $this;
    }

    /**
     * Get oilLt
     *
     * @return string
     */
    public function getOilLt()
    {
        return $this->oilLt;
    }

    /**
     * Set oilCost
     *
     * @param string $oilCost
     *
     * @return Report
     */
    public function setOilCost($oilCost)
    {
        $this->oilCost = $oilCost;

        return $this;
    }

    /**
     * Get oilCost
     *
     * @return string
     */
    public function getOilCost()
    {
        return $this->oilCost;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Report
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set validated
     *
     * @param integer $validated
     *
     * @return Report
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return integer
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set serviceOrder
     *
     * @param \AppBundle\Entity\ServiceOrder\ServiceOrder $serviceOrder
     *
     * @return Report
     */
    public function setServiceOrder(\AppBundle\Entity\ServiceOrder\ServiceOrder $serviceOrder = null)
    {
        $this->serviceOrder = $serviceOrder;

        return $this;
    }

    /**
     * Get serviceOrder
     *
     * @return \AppBundle\Entity\ServiceOrder\ServiceOrder
     */
    public function getServiceOrder()
    {
        return $this->serviceOrder;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Report
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getSubmitDate()
    {
        return $this->submitDate;
    }

    /**
     * @param $submitDate
     * @return $this
     */
    public function setSubmitDate($submitDate)
    {
        $this->submitDate = $submitDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEditDate()
    {
        return $this->editDate;
    }

    /**
     * @param $editDate
     * @return $this
     */
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;
        return $this;
    }



}
