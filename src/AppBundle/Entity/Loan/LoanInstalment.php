<?php

namespace AppBundle\Entity\Loan;

use AppBundle\Entity\Invoice\InvoiceDetailInterface;
use AppBundle\Entity\Payment\PayableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoanInstalmentRepository")
 * @ORM\Table(name="loan_instalments")
 */
class LoanInstalment implements PayableInterface, InvoiceDetailInterface
{
    /**
     * @ORM\Column(type="integer", name="loanInstalmentId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $loanInstalmentId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Loan\Loan", inversedBy="loanInstalments", cascade={"persist"})
     * @ORM\JoinColumn(name="loanId", referencedColumnName="loanId")
     */
    protected $loan;

    /**
     * @ORM\Column(type="integer", length=3, nullable=false, name="instalmentNumber")
     * @Assert\NotBlank(message="Instalment number cannot be null")
     */
    protected $instalmentNumber;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="paymentDate")
     * @Assert\NotBlank(message="Instalment payment date must not be null")
     */
    protected $paymentDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="amount")
     * @Assert\NotBlank(message="Instalment Amount must not be null")
     */
    protected $amount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="capital")
     * @Assert\NotBlank(message="Capital must not be null")
     */
    protected $capital;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="interests")
     * @Assert\NotBlank(message="Interests cannot be null")
     */
    protected $interests;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="interestRate")
     * @Assert\NotBlank(message="Interest Rate cannot be null")
     */
    protected $interestRate;

    /**
     * @ORM\Column(type="string", length=16, nullable=false, name="paymentType")
     * @Assert\NotBlank(message="Payment Type cannot be null")
     */
    protected $paymentType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Payment\BankAccount")
     * @ORM\JoinColumn(name="bankAccountId", referencedColumnName="bankAccountId")
     */
    protected $bankAccount;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Payment\Payment")
     * @ORM\JoinColumn(name="paymentId", referencedColumnName="paymentId")
     */
    protected $payment;


    /**
     * Get loanInstalmentId
     *
     * @return integer
     */
    public function getLoanInstalmentId()
    {
        return $this->loanInstalmentId;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return LoanInstalment
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return LoanInstalment
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
     * Set capital
     *
     * @param string $capital
     *
     * @return LoanInstalment
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * Get capital
     *
     * @return string
     */
    public function getCapital()
    {
        return $this->capital;
    }

    /**
     * Set interests
     *
     * @param string $interests
     *
     * @return LoanInstalment
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;

        return $this;
    }

    /**
     * Get interests
     *
     * @return string
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Set interestRate
     *
     * @param string $interestRate
     *
     * @return LoanInstalment
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
     * Set paymentType
     *
     * @param string $paymentType
     *
     * @return LoanInstalment
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
     * Set loan
     *
     * @param \AppBundle\Entity\Loan\Loan $loan
     *
     * @return LoanInstalment
     */
    public function setLoan(\AppBundle\Entity\Loan\Loan $loan = null)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return \AppBundle\Entity\Loan\Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }

    /**
     * Set bankAccount
     *
     * @param \AppBundle\Entity\Payment\BankAccount $bankAccount
     *
     * @return LoanInstalment
     */
    public function setBankAccount(\AppBundle\Entity\Payment\BankAccount $bankAccount = null)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * Get bankAccount
     *
     * @return \AppBundle\Entity\Payment\BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /*
     * START OF PAYABLE INTERFACE
     */

    public function getReceivedInvoice()
    {
        return null;
    }

    public function getIssuedInvoice()
    {
        return null;
    }

    public function getDirection()
    {
        return 'OUT';
    }

    public function getCausal()
    {
        return 'Pagamento Rata del mutuo ' . $this->getLoan()->getLoanNumber();
    }

    public function getCustomer()
    {
        return null;
    }

    public function getProvider()
    {
        return $this->getLoan()->getProvider();
    }

    /*
     * END OF PAYABLE INTERFACE
     */

    /*
     * START OF INVOICEINTERFACE
     */

    public function getInvoicePrice(): float
    {
        return $this->getAmount();
    }

    public function getProductName(): string
    {
        return $this->getCausal();
    }

    public function getProductCode(): string
    {
        return '000';
    }

    public function getInvoiceVat()
    {
        return '22';
    }

    public function getParentProvider()
    {
        return $this->getLoan()->getProvider();
    }

    public function getInvoiceCustomer()
    {
        return null;
    }

    /*
     * END OF INVOICEINTERFACE
     */

    /**
     * Set instalmentNumber
     *
     * @param integer $instalmentNumber
     *
     * @return LoanInstalment
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
     * Set payment.
     *
     * @param \AppBundle\Entity\Payment\Payment|null $payment
     *
     * @return LoanInstalment
     */
    public function setPayment(\AppBundle\Entity\Payment\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment.
     *
     * @return \AppBundle\Entity\Payment\Payment|null
     */
    public function getPayment()
    {
        return $this->payment;
    }
}
