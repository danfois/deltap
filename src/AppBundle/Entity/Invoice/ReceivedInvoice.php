<?php

namespace AppBundle\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReceivedInvoiceRepository")
 * @ORM\Table(name="received_invoices")
 */
class ReceivedInvoice extends Invoice
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice\InvoiceDetail", mappedBy="receivedInvoice", cascade={"persist"})
     */
    protected $invoiceDetails;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceDetails = new \Doctrine\Common\Collections\ArrayCollection();
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
}