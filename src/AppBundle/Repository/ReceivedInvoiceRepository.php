<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ReceivedInvoiceRepository extends EntityRepository
{
    public function findInvoicesByProvider(int $providerId)
    {
        $query = $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.provider = :p')
            ->setParameter(':i', $providerId)
            ->getQuery();
        return $query->getResult();
    }
}