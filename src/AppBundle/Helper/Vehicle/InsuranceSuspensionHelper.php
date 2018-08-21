<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\InsuranceSuspension;
use Doctrine\ORM\EntityManager;

class InsuranceSuspensionHelper
{
    protected $instance;
    protected $em;
    protected $executed = 0;
    protected $isEdited;
    protected $errors;

    public function __construct(InsuranceSuspension $insuranceSuspension, EntityManager $em, bool $isEdited = false)
    {
        $this->instance = $insuranceSuspension;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->setStartDate();
        $this->setEndDate();
        $this->checkDateCoherence();
        $this->checkSameInsuranceSuspension();
        $this->checkDateValidity();
        $this->executed = 1;
    }

    protected function checkDateCoherence()
    {
        if($this->instance->getStartDate() < $this->instance->getEndDate()) return true;
        $this->errors .= 'La Data di inizio deve essere precedente a quella di scadenza<br>';
        return false;
    }

    protected function checkSameInsuranceSuspension()
    {
        $ci = $this->em->getRepository(InsuranceSuspension::class)->findSameInsuranceSuspension($this->instance->getStartDate(), $this->instance->getInsurance()->getInsuranceId());
        if($ci == null) return true;
        $this->errors .= 'Esiste già una sospensione di questa assicurazione per questo periodo di tempo<br>';
        return false;
    }

    protected function checkDateValidity()
    {
        if($this->instance->getStartDate() < $this->instance->getInsurance()->getStartDate()) {
            $this->errors .= 'La data di inizio sospensione non può essere precedente alla data di inizio della polizza<br>';
            return false;
        }
        return true;
    }

    protected function setStartDate()
    {
        if($this->instance->setStartDate(\DateTime::createFromFormat('d/m/Y', $this->instance->getStartDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di inizio<br>';
        return false;
    }

    protected function setEndDate()
    {
        if($this->instance->getEndDate() == null) return true;
        if($this->instance->setEndDate(\DateTime::createFromFormat('d/m/Y', $this->instance->getEndDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di scadenza<br>';
        return false;
    }

    public function getErrors()
    {
        if($this->executed = 0) throw new \Exception('Class not executed');
        return $this->errors;
    }
}