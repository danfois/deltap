<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MaintenanceDetailRepository extends EntityRepository
{
    public function findLastMaintenanceByDate($vehicle, $mt)
    {
        $query = $this->createQueryBuilder('m')
            ->select('m.expirationDate, v.plate, mt.maintenanceName, mm.startKm, mm.startDate')
            ->leftJoin('AppBundle\Entity\Vehicle\Maintenance', 'mm', 'WITH', 'm.maintenance = mm.maintenanceId')
            ->leftJoin('AppBundle\Entity\Vehicle\MaintenanceType', 'mt', 'WITH', 'm.maintenanceType = mt.maintenanceTypeId')
            ->leftJoin('AppBundle\Entity\Vehicle\Vehicle','v','WITH','mm.vehicle = v.vehicleId')
            ->where('mm.vehicle = :v AND m.maintenanceType = :m AND m.expirationDate IS NOT NULL')
            ->setParameter(':v', $vehicle)
            ->setParameter(':m', $mt)
            ->orderBy('m.expirationDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    public function findLastMaintenanceByKm($vehicle, $mt)
    {
        $query = $this->createQueryBuilder('m')
            ->select('m.expirationKm, v.plate, mt.maintenanceName, mm.startKm, mm.startDate')
            ->leftJoin('AppBundle\Entity\Vehicle\Maintenance', 'mm', 'WITH', 'm.maintenance = mm.maintenanceId')
            ->leftJoin('AppBundle\Entity\Vehicle\MaintenanceType', 'mt', 'WITH', 'm.maintenanceType = mt.maintenanceTypeId')
            ->leftJoin('AppBundle\Entity\Vehicle\Vehicle','v','WITH','mm.vehicle = v.vehicleId')
            ->where('mm.vehicle = :v AND m.maintenanceType = :m AND m.expirationKm IS NOT NULL')
            ->setParameter(':v', $vehicle)
            ->setParameter(':m', $mt)
            ->orderBy('m.expirationKm', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
        return $query->getOneOrNullResult();
    }
}