<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\DriverQualificationLetter;

class QualificationLetterHelper extends DrivingDocumentHelper
{
    public function execute()
    {
        $this->checkDateCoherence();
        $this->checkSameDocument();
        $this->executed = 1;
    }

    public function checkSameDocument()
    {
        $document = $this->em->getRepository(DriverQualificationLetter::class)->findOneBy(array('number' => $this->instance->getNumber()));
        if($document == null) return true;
        $this->errors .= 'Esiste già una carta qualificazione conducente con questo numero<br>';
        return false;
    }
}