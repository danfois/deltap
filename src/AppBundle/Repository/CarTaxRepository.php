<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class CarTaxRepository extends EntityRepository
{
    public function findSameCarTax($startDate, $vehicleId)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.vehicle = :vi AND c.endDate > :sd')
            ->setParameter(':sd', $startDate)
            ->setParameter(':vi', $vehicleId)
            ->getQuery();
        return $query->getResult();
    }
}