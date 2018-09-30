<?php

namespace AppBundle\Helper\Invoice;

use AppBundle\Entity\Invoice\Invoice;
use AppBundle\Entity\Invoice\InvoiceDetail;
use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use Doctrine\ORM\EntityManager;

class InvoiceDetailHelper
{
    protected $invoice;
    protected $detail;
    protected $em;
    protected $errors;
    protected $executed = 0;
    protected $isEdited;

    public function __construct(Invoice $invoice, InvoiceDetail $detail, EntityManager $entityManager, bool $isEdited)
    {
        $this->invoice = $invoice;
        $this->detail = $detail;
        $this->em = $entityManager;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->assignParent();
        //$this->calculateTotTaxInc();
        $this->executed = 1;
    }

    protected function assignParent()
    {
        if($this->invoice instanceof IssuedInvoice) {
            $this->detail->setIssuedInvoice($this->invoice);
            return true;
        }

        if($this->invoice instanceof ReceivedInvoice) {
            $this->detail->setReceivedInvoice($this->invoice);
            return true;
        }

        $this->errors .= 'Il tipo di fattura che si sta tentando di registrare non è corretto<br>';
        return false;
    }

    protected function calculateTotTaxInc()
    {
        $vat = $this->detail->getVat();
        $price = $this->detail->getTotTaxExc();

        try {
            $totTaxInc = (float)$price + (((float)$price / 100) * (int)$vat);
            $this->detail->setTotTaxInc(round($totTaxInc, 2));
        } catch(\Exception $e) {
            $this->errors .= 'Errore durante il calcolo del lordo per oggetto ' . $this->detail->getProductName() . '<br>';
            return false;
        }

        return true;
    }

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not executed');
        return $this->errors;
    }

}