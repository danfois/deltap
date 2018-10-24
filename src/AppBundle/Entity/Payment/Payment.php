<?php

namespace AppBundle\Entity\Payment;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentRepository")
 * @ORM\Table(name="payments")
 */
class Payment
{
    /**
     * @ORM\Column(type="integer", name="paymentId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $paymentId;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="paymentDate")
     * @Assert\NotBlank()
     */
    protected $paymentDate;

    /**
     * @ORM\Column(type="string", length=12, nullable=false, name="direction")
     * @Assert\NotBlank()
     */
    protected $direction;

    /**
     * @ORM\Column(type="string", nullable=false, length=32, name="paymentType")
     * @Assert\NotBlank()
     * @Assert\Length(max=32, maxMessage="Payment type is too long. Max 32 chars")
     */
    protected $paymentType;

    /**
     * @ORM\Column(type="string", length=12, nullable=true, name="checkNumber")
     * @Assert\Length(max=12, maxMessage="Check Number is too long. Max 12 chars")
     */
    protected $checkNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="checkDate")
     */
    protected $checkDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="amout")
     * @Assert\NotBlank()
     * @Assert\Length(max=10)
     */
    protected $amount;

    /**
     * @ORM\Column(type="string", nullable=false, name="causal")
     * @Assert\NotBlank()
     */
    protected $causal;

    /**
     * @ORM\Column(type="string", nullable=true, name="description")
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="idCustomer")
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="providerId", referencedColumnName="idProvider", nullable=true)
     */
    protected $provider;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Payment\BankAccount")
     * @ORM\JoinColumn(name="bankAccountId", referencedColumnName="bankAccountId", nullable=true)
     */
    protected $bankAccount;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice\IssuedInvoice", inversedBy="payments")
     * @ORM\JoinColumn(name="issuedInvoiceId", referencedColumnName="invoiceId", nullable=true)
     */
    protected $issuedInvoice;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice\ReceivedInvoice", inversedBy="payments")
     * @ORM\JoinColumn(name="receivedInvoiceId", referencedColumnName="invoiceId", nullable=true)
     */
    protected $receivedInvoice;



    /**
     * Get paymentId
     *
     * @return integer
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return Payment
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
     * Set direction
     *
     * @param string $direction
     *
     * @return Payment
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set paymentType
     *
     * @param string $paymentType
     *
     * @return Payment
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
     * Set checkNumber
     *
     * @param string $checkNumber
     *
     * @return Payment
     */
    public function setCheckNumber($checkNumber)
    {
        $this->checkNumber = $checkNumber;

        return $this;
    }

    /**
     * Get checkNumber
     *
     * @return string
     */
    public function getCheckNumber()
    {
        return $this->checkNumber;
    }

    /**
     * Set checkDate
     *
     * @param \DateTime $checkDate
     *
     * @return Payment
     */
    public function setCheckDate($checkDate)
    {
        $this->checkDate = $checkDate;

        return $this;
    }

    /**
     * Get checkDate
     *
     * @return \DateTime
     */
    public function getCheckDate()
    {
        return $this->checkDate;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Payment
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
     * @return Payment
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
     * Set description
     *
     * @param string $description
     *
     * @return Payment
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
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Payment
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set provider
     *
     * @param \AppBundle\Entity\Provider $provider
     *
     * @return Payment
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
     * Set bankAccount
     *
     * @param \AppBundle\Entity\Payment\BankAccount $bankAccount
     *
     * @return Payment
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

    /**
     * Set issuedInvoice
     *
     * @param \AppBundle\Entity\Invoice\IssuedInvoice $issuedInvoice
     *
     * @return Payment
     */
    public function setIssuedInvoice(\AppBundle\Entity\Invoice\IssuedInvoice $issuedInvoice = null)
    {
        $this->issuedInvoice = $issuedInvoice;

        return $this;
    }

    /**
     * Get issuedInvoice
     *
     * @return \AppBundle\Entity\Invoice\IssuedInvoice
     */
    public function getIssuedInvoice()
    {
        return $this->issuedInvoice;
    }

    /**
     * Set receivedInvoice
     *
     * @param \AppBundle\Entity\Invoice\ReceivedInvoice $receivedInvoice
     *
     * @return Payment
     */
    public function setReceivedInvoice(\AppBundle\Entity\Invoice\ReceivedInvoice $receivedInvoice = null)
    {
        $this->receivedInvoice = $receivedInvoice;

        return $this;
    }

    /**
     * Get receivedInvoice
     *
     * @return \AppBundle\Entity\Invoice\ReceivedInvoice
     */
    public function getReceivedInvoice()
    {
        return $this->receivedInvoice;
    }
}
