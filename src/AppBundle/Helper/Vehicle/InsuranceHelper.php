<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\Insurance;
use Doctrine\ORM\EntityManager;

class InsuranceHelper
{
    private $insurance;
    private $em;
    private $errors;
    private $executed = 0;

    public function __construct(Insurance $insurance, EntityManager $em)
    {
        $this->insurance = $insurance;
        $this->em = $em;
    }

    public function execute()
    {
        $this->setInsuranceStartDate();
        $this->setInsuranceEndDate();
        $this->checkSameInsurance();
        $this->checkDateCoherence();
        $this->executed = 1;
    }

    private function checkSameInsurance()
    {
        $sameInsurance = $this->em->getRepository(Insurance::class)->findSameInsurance($this->insurance->getStartDate(), $this->insurance->getVehicle()->getVehicleId());
        if($sameInsurance == null) return true;
        $this->errors .= 'Esiste già una assicurazione per questo veicolo in questo lasso di tempo<br>';
        return false;
    }

    private function checkDateCoherence()
    {
        if($this->insurance->getStartDate() < $this->insurance->getEndDate()) return true;
        $this->errors .= 'La Data di inizio della polizza deve essere precedente a quella di scadenza<br>';
        return false;
    }

    private function setInsuranceStartDate()
    {
        if($this->insurance->setStartDate(\DateTime::createFromFormat('d/m/Y', $this->insurance->getStartDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di inizio dell\'assicurazione<br>';
        return false;
    }

    private function setInsuranceEndDate()
    {
        if($this->insurance->setEndDate(\DateTime::createFromFormat('d/m/Y', $this->insurance->getEndDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di scadenza dell\'assicurazione<br>';
        return false;
    }

    public function getErrors()
    {
        if($this->executed = 0) throw new \Exception('Class not executed');
        return $this->errors;
    }
}