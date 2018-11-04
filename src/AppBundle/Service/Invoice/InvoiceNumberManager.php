<?php

namespace AppBundle\Service\Invoice;

use AppBundle\Entity\Invoice\IssuedInvoice;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceNumberManager
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getCurrentInvoiceNumber() : int
    {
        $lastNumber = $this->em->getRepository(IssuedInvoice::class)->findLastInvoiceNumber();

        if($lastNumber == null) return 1;

        return (int) $lastNumber + 1;
    }

    public function getCurrentPaInvoiceNumber() : int
    {
        $lastNumber = $this->em->getRepository(IssuedInvoice::class)->findLastPaInvoiceNumber();

        if($lastNumber == null) return 1;

        return (int) $lastNumber + 1;
    }

    public function getCurrentProformaNumber() : int
    {
        $lastNumber = $this->em->getRepository(IssuedInvoice::class)->findLastProformaNumber();

        if($lastNumber == null) return 1;

        return (int) $lastNumber + 1;
    }
}