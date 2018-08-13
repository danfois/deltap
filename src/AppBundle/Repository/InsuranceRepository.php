<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class InsuranceRepository extends EntityRepository
{
    public function findSameInsurance($startDate, $vehicleId)
    {
        $query = $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.vehicle = :vi AND i.endDate > :sd')
            ->setParameter(':sd', $startDate)
            ->setParameter(':vi', $vehicleId)
            ->getQuery();
        return $query->getResult();
    }
}