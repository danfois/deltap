<?php

namespace AppBundle\Helper\Invoice;

use AppBundle\Entity\Invoice\Invoice;
use AppBundle\Entity\Invoice\IssuedInvoice;
use Doctrine\ORM\EntityManager;

class IssuedInvoiceHelper extends InvoiceHelper
{
    public function __construct(Invoice $invoice, EntityManager $entityManager, $isEdited)
    {
        parent::__construct($invoice, $entityManager, $isEdited);
    }

    public function execute()
    {
        $this->checkInvoiceNumber();
        $this->checkPaInvoiceNumber();
        $this->checkPaReceiptDate();
        $this->iterateDetails();
        $this->executed = 1;
    }

    protected function iterateDetails()
    {
        if ($this->invoice instanceof IssuedInvoice) {
            foreach ($this->invoice->getInvoiceDetails() as $d) {
                $DH = new InvoiceDetailHelper($this->invoice, $d, $this->em, $this->isEdited);
                $DH->execute();
                $this->errors .= $DH->getErrors();
            }
        }
    }

    protected function checkInvoiceNumber()
    {
        $invoice = $this->em->getRepository(IssuedInvoice::class)->findOneBy(array('invoiceNumber' => $this->invoice->getInvoiceNumber()));
        if ($invoice == null) return true;
        $this->errors .= 'Esiste già una fattura con questo numero<br>';
        return false;
    }

    protected function checkPaInvoiceNumber()
    {
        if ($this->invoice->getPaInvoice() != null && $this->invoice->getPaInvoice() != 0) {
            $invoice = $this->em->getRepository(IssuedInvoice::class)->findOneBy(array('paInvoice' => 1, 'paInvoiceNumber' => $this->invoice->getPaInvoiceNumber()));
            if ($invoice == null) return true;
            $this->errors .= 'Esiste già una fattura per la pubblica amministrazione con questo numero<br>';
            return false;
        }
        return true;
    }

    /*
     * I need this function to debug the datetime format
     */
    protected function checkPaReceiptDate()
    {
        if($this->invoice->getPaReceiptDate() == '') $this->invoice->setPaReceiptDate(null);
    }
}