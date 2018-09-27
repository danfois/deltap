<?php

namespace AppBundle\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IssuedInvoiceRepository")
 * @ORM\Table(name="issued_invoices")
 */
class IssuedInvoice extends Invoice
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotation")
     * @ORM\JoinColumn(name="priceQuotationId", referencedColumnName="priceQuotationId")
     */
    protected $priceQuotation;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice\InvoiceDetail", mappedBy="issuedInvoice")
     */
    protected $invoiceDetails;
}