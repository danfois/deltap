<?php

namespace AppBundle\Helper\Invoice;

use AppBundle\Entity\Invoice\Invoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use Doctrine\ORM\EntityManager;

class ReceivedInvoiceHelper extends InvoiceHelper
{
    public function __construct(Invoice $invoice, EntityManager $entityManager, $isEdited)
    {
        parent::__construct($invoice, $entityManager, $isEdited);
    }

    public function execute()
    {
        $this->checkPaReceiptDate();
        $this->iterateDetails();
        $this->executed = 1;
    }

    protected function iterateDetails()
    {
        if ($this->invoice instanceof ReceivedInvoice) {
            foreach ($this->invoice->getInvoiceDetails() as $d) {
                $DH = new InvoiceDetailHelper($this->invoice, $d, $this->em, $this->isEdited);
                $DH->execute();
                $this->errors .= $DH->getErrors();
            }
        }
    }

    /*
     * I need this function to debug the datetime format
     */
    protected function checkPaReceiptDate()
    {
        if($this->invoice->getPaReceiptDate() == '') $this->invoice->setPaReceiptDate(null);
    }
}