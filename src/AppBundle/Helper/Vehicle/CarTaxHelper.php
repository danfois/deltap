<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\CarTax;
use Doctrine\ORM\EntityManager;

class CarTaxHelper
{
    protected $carTax;
    protected $em;
    protected $errors;
    protected $isEdited;
    protected $executed = 0;

    public function __construct(CarTax $carTax, EntityManager $em, bool $isEdited)
    {
        $this->carTax = $carTax;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->setCarTaxStartDate();
        $this->setCarTaxEndDate();
        $this->checkDateCoherence();
        if($this->isEdited === false) $this->checkSameCarTax();
        $this->executed = 1;
    }

    private function checkSameCarTax()
    {
        $sameInsurance = $this->em->getRepository(CarTax::class)->findSameCarTax($this->carTax->getStartDate(), $this->carTax->getVehicle()->getVehicleId());
        if($sameInsurance == null) return true;
        $this->errors .= 'Esiste già un bollo per questo veicolo in questo lasso di tempo<br>';
        return false;
    }

    protected function checkDateCoherence()
    {
        if($this->carTax->getStartDate() < $this->carTax->getEndDate()) return true;
        $this->errors .= 'La Data di inizio del bollo deve essere precedente a quella di scadenza<br>';
        return false;
    }

    protected function setCarTaxStartDate()
    {
        if($this->carTax->setStartDate(\DateTime::createFromFormat('d/m/Y', $this->carTax->getStartDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di inizio del bollo<br>';
        return false;
    }

    protected function setCarTaxEndDate()
    {
        if($this->carTax->setEndDate(\DateTime::createFromFormat('d/m/Y', $this->carTax->getEndDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di scadenza del bollo<br>';
        return false;
    }

    public function getErrors()
    {
        if($this->executed = 0) throw new \Exception('Class not executed');
        return $this->errors;
    }
}