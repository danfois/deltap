<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\CarTax;
use Doctrine\ORM\EntityManager;

class CarTaxHelper extends AbstractPeriodicCostHelper
{
    protected $em;
    protected $errors;
    protected $isEdited;
    protected $executed = 0;

    public function __construct(CarTax $carTax, EntityManager $em, bool $isEdited = false)
    {
        parent::__construct($carTax, $em, $isEdited);
    }

    public function execute()
    {
        $this->setStartDate();
        $this->setEndDate();
        $this->checkDateCoherence();
        if($this->isEdited === false) $this->checkSameCarTax();
        $this->executed = 1;
    }

    private function checkSameCarTax()
    {
        $sameCarTax = $this->em->getRepository(CarTax::class)->findSameCarTax($this->instance->getStartDate(), $this->instance->getVehicle()->getVehicleId());
        if($sameCarTax == null) return true;
        $this->errors .= 'Esiste già un bollo per questo veicolo in questo lasso di tempo<br>';
        return false;
    }
}