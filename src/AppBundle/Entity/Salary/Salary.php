<?php

namespace AppBundle\Entity\Salary;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalaryRepository")
 * @ORM\Table(name="salaries")
 */
class Salary
{
    /**
     * @ORM\Column(type="integer", name="salaryId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $salaryId;

    /**
     * @ORM\Column(type="integer", length=4, name="year", nullable=false)
     * @Assert\NotBlank(message="Salary year cannot be null")
     * @Assert\Length(max=4, maxMessage="Salary year too long. Max 4 chars")
     */
    protected $year;

    /**
     * @ORM\Column(type="integer", length=2, nullable=false, name="month")
     * @Assert\NotBlank(message="Salary month cannot be nulL")
     */
    protected $month;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="amount")
     * @Assert\NotBlank(message="Salary amount cannot be null")
     */
    protected $amount;

    /**
     * @ORM\Column(type="string", nullable=true, name="causal")
     */
    protected $causal;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Salary\SalaryDetail", mappedBy="salary", cascade={"persist"})
     */
    protected $salaryDetails;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Employee")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    protected $employee;

    /**
     * @ORM\Column(type="text", nullable=true, name="notes")
     */
    protected $notes;

    /**
     * Get salaryId
     *
     * @return integer
     */
    public function getSalaryId()
    {
        return $this->salaryId;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Salary
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return Salary
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Salary
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
     * Set causal
     *
     * @param string $causal
     *
     * @return Salary
     */
    public function setCausal($causal)
    {
        $this->causal = $causal;

        return $this;
    }

    /**
     * Get causal
     *
     * @return string
     */
    public function getCausal()
    {
        return $this->causal;
    }


    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return Salary
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
     * Constructor
     */
    public function __construct()
    {
        $this->salaryDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add salaryDetail
     *
     * @param \AppBundle\Entity\Salary\SalaryDetail $salaryDetail
     *
     * @return Salary
     */
    public function addSalaryDetail(\AppBundle\Entity\Salary\SalaryDetail $salaryDetail)
    {
        $this->salaryDetails[] = $salaryDetail;

        return $this;
    }

    /**
     * Remove salaryDetail
     *
     * @param \AppBundle\Entity\Salary\SalaryDetail $salaryDetail
     */
    public function removeSalaryDetail(\AppBundle\Entity\Salary\SalaryDetail $salaryDetail)
    {
        $this->salaryDetails->removeElement($salaryDetail);
    }

    /**
     * Get salaryDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSalaryDetails()
    {
        return $this->salaryDetails;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Salary
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
}
