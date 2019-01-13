<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\ServiceOrder\Report;
use AppBundle\Entity\Vehicle\MaintenanceDetail;
use AppBundle\Entity\Vehicle\MaintenanceRelationship;
use AppBundle\Entity\Vehicle\MaintenanceType;
use AppBundle\Entity\Vehicle\Vehicle;
use Doctrine\ORM\EntityManager;

class ExpiringMaintenanceProvider
{
    protected $vehicle;
    protected $em;
    protected $preparedData;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    protected function fetchRelationships()
    {
        if($this->vehicle != null) {
            return $this->em->getRepository(MaintenanceRelationship::class)->findBy(array('vehicle' => $this->vehicle));
        } else {
            return $this->em->getRepository(MaintenanceRelationship::class)->findAll();
        }
    }

    public function prepareData()
    {
        $r = $this->fetchRelationships();
        $lastReports = array();
        $preparedData = array();

        foreach($r as $rr) {

            $lastMaintenance = $this->em->getRepository(MaintenanceDetail::class)->findLastMaintenanceByDate($rr->getVehicle(), $rr->getMaintenanceType());

            if($lastMaintenance == null || $lastMaintenance['expirationDate'] === null) {

                $lastMaintenance = $this->em->getRepository(MaintenanceDetail::class)->findLastMaintenanceByKm($rr->getVehicle(), $rr->getMaintenanceType());

                if($lastMaintenance == null) {

                    $lastMaintenance = array(
                        'plate' => $rr->getVehicle()->getPlate(),
                        'maintenanceName' => $rr->getMaintenanceType()->getMaintenanceName(),
                        'expirationDate' => 0,
                        'expirationKm' => $rr->getMaintenanceType()->getKmInterval(),
                        'startKm' => 'MAI FATTA',
                        'startDate' => 'MAI FATTA'
                    );

                }

            }

            if(array_key_exists($rr->getVehicle()->getPlate(), $lastReports) === true) {
                $lastMaintenance['currentKm'] = $lastReports[$rr->getVehicle()->getPlate()]['endKm'];
            } else {
                $lastReport = $this->em->getRepository(Report::class)->getLastReportFromSoByVehicle($rr->getVehicle());
                $lastReports[$rr->getVehicle()->getPlate()] = $lastReport;
                $lastMaintenance['currentKm'] = $lastReport['endKm'];
            }

            $preparedData[] = $lastMaintenance;
        }

        $this->preparedData = $preparedData;

        return $this;
    }

    public function getPreparedData()
    {
        return $this->preparedData;
    }
}