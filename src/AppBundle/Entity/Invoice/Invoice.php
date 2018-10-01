<?php

namespace AppBundle\Entity\Invoice;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @ORM\Column(type="integer", nullable=false, name="invoiceNumber")
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
     * @ORM\Column(type="integer", nullable=false, length=1, name="pa_invoice")
     */
    protected $paInvoice;

    /**
     * @ORM\Column(type="integer", nullable=true, name="pa_invoice_number")
     */
    protected $paInvoiceNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="pa_receipt_date")
     */
    protected $pa_receipt_date;


    /**
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @param mixed $invoiceId
     * @return Invoice
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param mixed $invoiceDate
     * @return Invoice
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param mixed $invoiceNumber
     * @return Invoice
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCausal()
    {
        return $this->causal;
    }

    /**
     * @param mixed $causal
     * @return Invoice
     */
    public function setCausal($causal)
    {
        $this->causal = $causal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentTerms()
    {
        return $this->paymentTerms;
    }

    /**
     * @param mixed $paymentTerms
     * @return Invoice
     */
    public function setPaymentTerms($paymentTerms)
    {
        $this->paymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaInvoice()
    {
        return $this->paInvoice;
    }

    /**
     * @param mixed $paInvoice
     * @return Invoice
     */
    public function setPaInvoice($paInvoice)
    {
        $this->paInvoice = $paInvoice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaInvoiceNumber()
    {
        return $this->paInvoiceNumber;
    }

    /**
     * @param mixed $paInvoiceNumber
     * @return Invoice
     */
    public function setPaInvoiceNumber($paInvoiceNumber)
    {
        $this->paInvoiceNumber = $paInvoiceNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaReceiptDate()
    {
        return $this->pa_receipt_date;
    }

    /**
     * @param mixed $pa_receipt_date
     * @return Invoice
     */
    public function setPaReceiptDate($pa_receipt_date)
    {
        $this->pa_receipt_date = $pa_receipt_date;
        return $this;
    }

}
