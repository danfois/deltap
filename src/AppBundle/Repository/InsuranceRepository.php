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

    public function findActiveInsurancesPerVehicle($idV)
    {
        $query = $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.vehicle = :vi AND i.isActive = 1')
            ->setParameter(':vi', $idV)
            ->getQuery();
        return $query->getResult();
    }
}