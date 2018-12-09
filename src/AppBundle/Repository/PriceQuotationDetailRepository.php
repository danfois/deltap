<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PriceQuotationDetailRepository extends EntityRepository
{
    public function findHighestId()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.priceQuotationDetailId')
            ->orderBy('p.priceQuotationDetailId', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    public function findPqdInArray($data)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.priceQuotationDetailId IN (:dataarray)')
            ->setParameter(':dataarray', $data)
            ->getQuery();
        return $query->getResult();
    }
}