<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PriceQuotationRepository extends EntityRepository
{
    public function findHighestId()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.priceQuotationId')
            ->orderBy('p.priceQuotationId')
            ->setMaxResults(1)
            ->getQuery();
        return $query->getSingleScalarResult();
    }
}