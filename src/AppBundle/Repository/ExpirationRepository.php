<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ExpirationRepository extends EntityRepository
{
    public function findExpiringInvoices()
    {
        $query = $this->createQueryBuilder('e')
            ->select('e')
            ->where('(e.issuedInvoice IS NOT NULL OR e.receivedInvoice IS NOT NULL) AND e.isResolved = false')
            ->getQuery();
        return $query->getResult();
    }
}