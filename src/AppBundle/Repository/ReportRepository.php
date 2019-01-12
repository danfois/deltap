<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ReportRepository extends EntityRepository
{
    public function getLastReportFromSoByVehicle($vehicle)
    {
        $query = $this->createQueryBuilder('r')
            ->select('r.endKm, IDENTITY(o.vehicle), o.arrivalDate')
            ->leftJoin('AppBundle\Entity\ServiceOrder\ServiceOrder', 'o', 'WITH', 'r.serviceOrder = o.serviceOrder')
            ->where('o.vehicle = :v')
            ->setParameter(':v', $vehicle)
            ->orderBy('o.arrivalDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
        return $query->getOneOrNullResult();
    }
}