<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PriceQuotationDetailRepository extends EntityRepository
{
    public function findHighestId()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.priceQuotationDetailId')
            ->orderBy('p.priceQuotationDetailId')
            ->setMaxResults(1)
            ->getQuery();
        return $query->getSingleScalarResult();
    }
}