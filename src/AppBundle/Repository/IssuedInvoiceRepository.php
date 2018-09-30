<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class IssuedInvoiceRepository extends EntityRepository
{
    public function findLastInvoiceNumber()
    {
        $query = $this->createQueryBuilder('i')
            ->select('MAX(i.invoiceNumber)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }
}