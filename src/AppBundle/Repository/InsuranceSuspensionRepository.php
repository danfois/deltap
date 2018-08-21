<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class InsuranceSuspensionRepository extends EntityRepository
{
    public function findSameInsuranceSuspension($startDate, $insuranceId)
    {
        $query = $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.insurance = :vi AND i.endDate > :sd')
            ->setParameter(':sd', $startDate)
            ->setParameter(':vi', $insuranceId)
            ->getQuery();
        return $query->getResult();
    }
}