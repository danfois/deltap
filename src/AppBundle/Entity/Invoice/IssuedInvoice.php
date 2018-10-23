<?php

namespace AppBundle\Entity\Invoice;
use AppBundle\Entity\Payment\PayableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IssuedInvoiceRepository")
 * @ORM\Table(name="issued_invoices")
 */
class IssuedInvoice extends Invoice implements PayableInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotation")
     * @ORM\JoinColumn(name="priceQuotationId", referencedColumnName="priceQuotationId")
     */
    protected $priceQuotation;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice\InvoiceDetail", mappedBy="issuedInvoice", cascade={"persist", "remove", "refresh"}, orphanRemoval=true)
     */
    protected $invoiceDetails;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="idCustomer")
     */
    protected $customer;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment\Payment", mappedBy="issuedInvoice")
     */
    protected $payments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     * @return Invoice
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Set priceQuotation
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotation $priceQuotation
     *
     * @return IssuedInvoice
     */
    public function setPriceQuotation(\AppBundle\Entity\PriceQuotation\PriceQuotation $priceQuotation = null)
    {
        $this->priceQuotation = $priceQuotation;

        return $this;
    }

    /**
     * Get priceQuotation
     *
     * @return \AppBundle\Entity\PriceQuotation\PriceQuotation
     */
    public function getPriceQuotation()
    {
        return $this->priceQuotation;
    }

    /**
     * Add invoiceDetail
     *
     * @param \AppBundle\Entity\Invoice\InvoiceDetail $invoiceDetail
     *
     * @return IssuedInvoice
     */
    public function addInvoiceDetail(\AppBundle\Entity\Invoice\InvoiceDetail $invoiceDetail)
    {
        $this->invoiceDetails[] = $invoiceDetail;

        return $this;
    }

    /**
     * Remove invoiceDetail
     *
     * @param \AppBundle\Entity\Invoice\InvoiceDetail $invoiceDetail
     */
    public function removeInvoiceDetail(\AppBundle\Entity\Invoice\InvoiceDetail $invoiceDetail)
    {
        $this->invoiceDetails->removeElement($invoiceDetail);
    }

    /**
     * Get invoiceDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoiceDetails()
    {
        return $this->invoiceDetails;
    }

    /*
     * START OF PAYABLE INTERFACE METHODS
     */
    public function getAmount()
    {
        $sum = 0;

        foreach($this->getInvoiceDetails() as $d) {
            $sum += $d->getTotTaxInc();
        }

        return $sum;
    }

    public function getCausal()
    {
        return 'Pagamento Fattura emessa N. ' . $this->getInvoiceNumber();
    }

    public function getDirection()
    {
        return 'IN';
    }

    public function getIssuedInvoice()
    {
        return $this;
    }

    public function getReceivedInvoice()
    {
        return null;
    }

    public function getPaymentDate()
    {
        return $this->getInvoiceDate();
    }

    public function getProvider()
    {
        return null;
    }

    /*
     * END OF PAYABLE INTERFACE METHODS
     */

    /**
     * Add payment
     *
     * @param \AppBundle\Entity\Payment\Payment $payment
     *
     * @return IssuedInvoice
     */
    public function addPayment(\AppBundle\Entity\Payment\Payment $payment)
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * Remove payment
     *
     * @param \AppBundle\Entity\Payment\Payment $payment
     */
    public function removePayment(\AppBundle\Entity\Payment\Payment $payment)
    {
        $this->payments->removeElement($payment);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
