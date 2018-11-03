<?php

namespace AppBundle\Entity\Salary;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="salary_details")
 */
class SalaryDetail
{
    /**
     * @ORM\Column(type="integer", name="salaryDetailId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $salaryDetailId;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Payment\Payment", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="paymentId", referencedColumnName="paymentId")
     */
    protected $payment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Salary\Salary", inversedBy="salaryDetails", cascade={"persist"})
     * @ORM\JoinColumn(name="salaryId", referencedColumnName="salaryId")
     */
    protected $salary;

    /**
     * Get salaryDetailId
     *
     * @return integer
     */
    public function getSalaryDetailId()
    {
        return $this->salaryDetailId;
    }

    /**
     * Set payment
     *
     * @param \AppBundle\Entity\Payment\Payment $payment
     *
     * @return SalaryDetail
     */
    public function setPayment(\AppBundle\Entity\Payment\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \AppBundle\Entity\Payment\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set salary
     *
     * @param \AppBundle\Entity\Salary\Salary $salary
     *
     * @return SalaryDetail
     */
    public function setSalary(\AppBundle\Entity\Salary\Salary $salary = null)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return \AppBundle\Entity\Salary\Salary
     */
    public function getSalary()
    {
        return $this->salary;
    }
}
