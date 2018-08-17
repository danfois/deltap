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
}