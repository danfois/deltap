<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\VehiclePeriodicCost;
use Doctrine\ORM\EntityManager;

abstract class AbstractPeriodicCostHelper
{
    protected $instance;
    protected $em;
    protected $errors;
    protected $idEdited;
    protected $executed = 0;

    public function __construct(VehiclePeriodicCost $instance, EntityManager $em, bool $isEdited = false)
    {
        $this->instance = $instance;
        $this->em = $em;
        $this->isEdited = $isEdited;
        $this->instance->setIsActive(0);
    }

    abstract public function execute();

    protected function checkDateCoherence()
    {
        if($this->instance->getStartDate() < $this->instance->getEndDate()) return true;
        $this->errors .= 'La Data di inizio deve essere precedente a quella di scadenza<br>';
        return false;
    }

    protected function setStartDate()
    {
        if($this->instance->setStartDate(\DateTime::createFromFormat('d/m/Y', $this->instance->getStartDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di inizio<br>';
        return false;
    }

    protected function setEndDate()
    {
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