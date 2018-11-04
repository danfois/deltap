<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\EmployeeUnavailability;
use AppBundle\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;

class UnavailabilityHelper extends AbstractHelper
{
    public function __construct(EmployeeUnavailability $employee, EntityManager $em, bool $isEdited = false)
    {
        $this->instance = $employee;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->checkDateCoherence();
        $this->executed = 1;
    }

    protected function checkDateCoherence()
    {
        if($this->instance->getEndDate() != null) {
            if($this->instance->getStartDate() > $this->instance->getEndDate()) {
                $this->errors .= 'La data di inizio indisponibilità non può essere successiva a quella di fine indisponibilità<br>';
                return false;
            }
            return true;
        }
        return true;
    }
}