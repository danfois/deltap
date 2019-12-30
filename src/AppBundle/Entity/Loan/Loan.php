<?php

namespace AppBundle\Entity\Loan;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoanRepository")
 * @ORM\Table(name="loans")
 */
class Loan
{
    /**
     * @ORM\Column(type="integer", name="loanId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $loanId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="providerId", referencedColumnName="idProvider")
     */
    protected $provider;

    /**
     * @ORM\Column(type="string", nullable=false, length=24, name="loanNumber")
     * @Assert\NotBlank(message="Loan number must not be null")
     * @Assert\Length(max=12, maxMessage="Loan Number is too long. Max 12 chars")
     */
    protected $loanNumber;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="loanDate")
     * @Assert\NotBlank(message="Loan Date must not be null")
     */
    protected $loanDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="financedAmount")
     * @Assert\NotBlank(message="Loan Financed Amount must not be null")
     */
    protected $financedAmount;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=false, name="interestRate")
     * @Assert\NotBlank(message="Interest Rate must not be null")
     */
    protected $interestRate;

    /**
     * @ORM\Column(type="string", length=12, nullable=false, name="interestType")
     * @Assert\NotBlank(message="Interest Type must not be null")
     */
    protected $interestType;

    /**
     * @ORM\Column(type="string", nullable=false, length=16, name="instalmentType")
     * @Assert\NotBlank(message="Instalment Type must not be null")
     */
    protected $instalmentType;

    /**
     * @ORM\Column(type="integer", nullable=false, length=4, name="instalmentNumber")
     * @Assert\NotBlank(message="Instalment Number must not be null")
     * @Assert\Length(max=4, maxMessage="Instalment Number must not be higher than 9999")
     */
    protected $instalmentNumber;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="firstInstalmentDate")
     * @Assert\NotBlank(message="First Instalment Date must not be null")
     */
    protected $firstInstalmentDate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="lastInstalmentDate")
     * @Assert\NotBlank(message="Last Instalment Date must not be null")
     */
    protected $lastInstalmentDate;

    /**
     * @ORM\Column(type="string", nullable=false, length=16, name="paymentType")
     * @Assert\NotBlank(message="Payment Type must not be null")
     */
    protected $paymentType;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="anticipation")
     * @Assert\NotBlank(message="Anticipation must not be null")
     */
    protected $anticipation;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="redemption")
     * @Assert\NotBlank(message="Redemption must not be nulL")
     */
    protected $redemption;

    /**
     * @ORM\Column(type="string", nullable=true, name="mortgages")
     */
    protected $mortgages;

    /**
     * @ORM\Column(type="string", nullable=true, name="notes")
     */
    protected $notes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="pre_amortization")
     * @Assert\NotBlank(message="Pre Amortization must not be null")
     */
    protected $preAmortization;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="operationCost")
     * @Assert\NotBlank(message="Operation Cost must not be nulL")
     */
    protected $operationCost;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="expectedInterests")
     * @Assert\NotBlank(message="Expected Interests cannot be null")
     */
    protected $expectedInterests;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="loanCost")
     * @Assert\NotBlank(message="Loan Cost cannot be null")
     */
    protected $loanCost;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="instalmentAmount")
     * @Assert\NotBlank(message="Instalment Amount cannot be null")
     */
    protected $instalmentAmount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Loan\LoanInstalment", mappedBy="loan", cascade={"persist"}, orphanRemoval=true)
     */
    protected $loanInstalments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loanInstalments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get loanId
     *
     * @return integer
     */
    public function getLoanId()
    {
        return $this->loanId;
    }

    public function setLoanId($loanId)
    {
        $this->loanId = $loanId;
        return $this;
    }

    /**
     * Set loanNumber
     *
     * @param string $loanNumber
     *
     * @return Loan
     */
    public function setLoanNumber($loanNumber)
    {
        $this->loanNumber = $loanNumber;

        return $this;
    }

    /**
     * Get loanNumber
     *
     * @return string
     */
    public function getLoanNumber()
    {
        return $this->loanNumber;
    }

    /**
     * Set loanDate
     *
     * @param \DateTime $loanDate
     *
     * @return Loan
     */
    public function setLoanDate($loanDate)
    {
        $this->loanDate = $loanDate;

        return $this;
    }

    /**
     * Get loanDate
     *
     * @return \DateTime
     */
    public function getLoanDate()
    {
        return $this->loanDate;
    }

    /**
     * Set financedAmount
     *
     * @param string $financedAmount
     *
     * @return Loan
     */
    public function setFinancedAmount($financedAmount)
    {
        $this->financedAmount = $financedAmount;

        return $this;
    }

    /**
     * Get financedAmount
     *
     * @return string
     */
    public function getFinancedAmount()
    {
        return $this->financedAmount;
    }

    /**
     * Set interestRate
     *
     * @param string $interestRate
     *
     * @return Loan
     */
    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    /**
     * Get interestRate
     *
     * @return string
     */
    public function getInterestRate()
    {
        return $this->interestRate;
    }

    /**
     * Set interestType
     *
     * @param string $interestType
     *
     * @return Loan
     */
    public function setInterestType($interestType)
    {
        $this->interestType = $interestType;

        return $this;
    }

    /**
     * Get interestType
     *
     * @return string
     */
    public function getInterestType()
    {
        return $this->interestType;
    }

    /**
     * Set instalmentType
     *
     * @param string $instalmentType
     *
     * @return Loan
     */
    public function setInstalmentType($instalmentType)
    {
        $this->instalmentType = $instalmentType;

        return $this;
    }

    /**
     * Get instalmentType
     *
     * @return string
     */
    public function getInstalmentType()
    {
        return $this->instalmentType;
    }

    /**
     * Set instalmentNumber
     *
     * @param integer $instalmentNumber
     *
     * @return Loan
     */
    public function setInstalmentNumber($instalmentNumber)
    {
        $this->instalmentNumber = $instalmentNumber;

        return $this;
    }

    /**
     * Get instalmentNumber
     *
     * @return integer
     */
    public function getInstalmentNumber()
    {
        return $this->instalmentNumber;
    }

    /**
     * Set firstInstalmentDate
     *
     * @param \DateTime $firstInstalmentDate
     *
     * @return Loan
     */
    public function setFirstInstalmentDate($firstInstalmentDate)
    {
        $this->firstInstalmentDate = $firstInstalmentDate;

        return $this;
    }

    /**
     * Get firstInstalmentDate
     *
     * @return \DateTime
     */
    public function getFirstInstalmentDate()
    {
        return $this->firstInstalmentDate;
    }

    /**
     * Set lastInstalmentDate
     *
     * @param \DateTime $lastInstalmentDate
     *
     * @return Loan
     */
    public function setLastInstalmentDate($lastInstalmentDate)
    {
        $this->lastInstalmentDate = $lastInstalmentDate;

        return $this;
    }

    /**
     * Get lastInstalmentDate
     *
     * @return \DateTime
     */
    public function getLastInstalmentDate()
    {
        return $this->lastInstalmentDate;
    }

    /**
     * Set paymentType
     *
     * @param string $paymentType
     *
     * @return Loan
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set anticipation
     *
     * @param string $anticipation
     *
     * @return Loan
     */
    public function setAnticipation($anticipation)
    {
        $this->anticipation = $anticipation;

        return $this;
    }

    /**
     * Get anticipation
     *
     * @return string
     */
    public function getAnticipation()
    {
        return $this->anticipation;
    }

    /**
     * Set redemption
     *
     * @param string $redemption
     *
     * @return Loan
     */
    public function setRedemption($redemption)
    {
        $this->redemption = $redemption;

        return $this;
    }

    /**
     * Get redemption
     *
     * @return string
     */
    public function getRedemption()
    {
        return $this->redemption;
    }

    /**
     * Set mortgages
     *
     * @param string $mortgages
     *
     * @return Loan
     */
    public function setMortgages($mortgages)
    {
        $this->mortgages = $mortgages;

        return $this;
    }

    /**
     * Get mortgages
     *
     * @return string
     */
    public function getMortgages()
    {
        return $this->mortgages;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Loan
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
     * Set preAmortization
     *
     * @param string $preAmortization
     *
     * @return Loan
     */
    public function setPreAmortization($preAmortization)
    {
        $this->preAmortization = $preAmortization;

        return $this;
    }

    /**
     * Get preAmortization
     *
     * @return string
     */
    public function getPreAmortization()
    {
        return $this->preAmortization;
    }

    /**
     * Set operationCost
     *
     * @param string $operationCost
     *
     * @return Loan
     */
    public function setOperationCost($operationCost)
    {
        $this->operationCost = $operationCost;

        return $this;
    }

    /**
     * Get operationCost
     *
     * @return string
     */
    public function getOperationCost()
    {
        return $this->operationCost;
    }

    /**
     * Set expectedInterests
     *
     * @param string $expectedInterests
     *
     * @return Loan
     */
    public function setExpectedInterests($expectedInterests)
    {
        $this->expectedInterests = $expectedInterests;

        return $this;
    }

    /**
     * Get expectedInterests
     *
     * @return string
     */
    public function getExpectedInterests()
    {
        return $this->expectedInterests;
    }

    /**
     * Set loanCost
     *
     * @param string $loanCost
     *
     * @return Loan
     */
    public function setLoanCost($loanCost)
    {
        $this->loanCost = $loanCost;

        return $this;
    }

    /**
     * Get loanCost
     *
     * @return string
     */
    public function getLoanCost()
    {
        return $this->loanCost;
    }

    /**
     * Set instalmentAmount
     *
     * @param string $instalmentAmount
     *
     * @return Loan
     */
    public function setInstalmentAmount($instalmentAmount)
    {
        $this->instalmentAmount = $instalmentAmount;

        return $this;
    }

    /**
     * Get instalmentAmount
     *
     * @return string
     */
    public function getInstalmentAmount()
    {
        return $this->instalmentAmount;
    }

    /**
     * Set provider
     *
     * @param \AppBundle\Entity\Provider $provider
     *
     * @return Loan
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
     * Add loanInstalment
     *
     * @param \AppBundle\Entity\Loan\LoanInstalment $loanInstalment
     *
     * @return Loan
     */
    public function addLoanInstalment(\AppBundle\Entity\Loan\LoanInstalment $loanInstalment)
    {
        $this->loanInstalments[] = $loanInstalment;

        return $this;
    }

    /**
     * Remove loanInstalment
     *
     * @param \AppBundle\Entity\Loan\LoanInstalment $loanInstalment
     */
    public function removeLoanInstalment(\AppBundle\Entity\Loan\LoanInstalment $loanInstalment)
    {
        $this->loanInstalments->removeElement($loanInstalment);
    }

    /**
     * Get loanInstalments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoanInstalments()
    {
        return $this->loanInstalments;
    }
}
