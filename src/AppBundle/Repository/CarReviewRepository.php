<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class CarReviewRepository extends EntityRepository
{
    public function findSameCarReview($startDate, $vehicleId)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.vehicle = :vi AND c.endDate > :sd')
            ->setParameter(':sd', $startDate)
            ->setParameter(':vi', $vehicleId)
            ->getQuery();
        return $query->getResult();
    }

    public function findActiveCarReviewPerVehicle($idV)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.vehicle = :vi AND c.isActive = 1')
            ->setParameter(':vi', $idV)
            ->getQuery();
        return $query->getResult();
    }
}