<?php

namespace AppBundle\Helper\Invoice;

use AppBundle\Entity\Invoice\Invoice;
use Doctrine\ORM\EntityManager;

abstract class InvoiceHelper
{
    protected $invoice;
    protected $em;
    protected $isEdited;
    protected $executed = 0;
    protected $errors;

    public function __construct(Invoice $invoice, EntityManager $entityManager, bool $isEdited)
    {
        $this->invoice = $invoice;
        $this->em = $entityManager;
        $this->isEdited = $isEdited;
    }

    abstract public function execute();

    abstract protected function iterateDetails();

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not executed');
        return $this->errors;
    }
}