<?php

namespace AppBundle\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReceivedInvoiceRepository")
 * @ORM\Table(name="received_invoices")
 */
class ReceivedInvoice extends Invoice
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice\InvoiceDetail", mappedBy="receivedInvoice")
     */
    protected $invoiceDetails;
}