<?php

namespace AppBundle\Entity\Invoice;
use AppBundle\Entity\Payment\PayableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReceivedInvoiceRepository")
 * @ORM\Table(name="received_invoices")
 */
class ReceivedInvoice extends Invoice implements PayableInterface
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice\InvoiceDetail", mappedBy="receivedInvoice", cascade={"persist"})
     */
    protected $invoiceDetails;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="providerId", referencedColumnName="idProvider")
     */
    protected $provider;


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
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     * @return Invoice
     */
    public function setProvider(\AppBundle\Entity\Provider $provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * Add invoiceDetail
     *
     * @param \AppBundle\Entity\Invoice\InvoiceDetail $invoiceDetail
     *
     * @return ReceivedInvoice
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
        return 'Pagamento Fattura Ricevuta N. ' . $this->getInvoiceNumber() . ' da ' . $this->getProvider()->getBusinessName();
    }

    public function getDirection()
    {
        return 'OUT';
    }

    public function getIssuedInvoice()
    {
        return null;
    }

    public function getReceivedInvoice()
    {
        return $this;
    }

    public function getPaymentDate()
    {
        return $this->getInvoiceDate();
    }

    public function getCustomer()
    {
        return null;
    }

    /*
     * END OF PAYABLE INTERFACE METHODS
     */
}
