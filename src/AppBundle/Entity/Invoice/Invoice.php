<?php

namespace AppBundle\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @MappedSuperClass
 */
abstract class Invoice
{
    /**
     * @ORM\Column(type="integer", name="invoiceId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $invoiceId;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="invoiceDate")
     * @Assert\NotBlank(message="Invoice date must not be null")
     */
    protected $invoiceDate;

    /**
     * @ORM\Column(type="int", nullable=false, name="invoiceNumber")
     * @Assert\NotBlank(message="Invoice Number cannot be null")
     */
    protected $invoiceNumber;

    //todo: inserire OneToMany per i pagamenti

    /**
     * @ORM\Column(type="text", nullable=false, name="causal")
     * @Assert\NotBlank(message="Invoice causal cannot be null")
     */
    protected $causal;

    /**
     * @ORM\Column(type="text", nullable=false, name="paymentTerms")
     * @Assert\NotBlank(message="Terms of Payment cannot be null")
     */
    protected $paymentTerms;

    /**
     * @ORM\Column(type="int", nullable=false, length=1, name="pa_invoice")
     */
    protected $paInvoice;

    /**
     * @ORM\Column(type="int", nullable=true, name="pa_invoice_number")
     */
    protected $paInvoiceNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="pa_receipt_date")
     */
    protected $pa_receipt_date;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customerId", referencedColumnName="idCustomer")
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="providerId", referencedColumnName="idProvider")
     */
    protected $provider;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice\InvoiceDetail", mappedBy="invoice")
     */
    protected $invoiceDetails;

}