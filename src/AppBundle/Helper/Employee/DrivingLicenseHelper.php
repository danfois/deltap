<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\DrivingLicense;

class DrivingLicenseHelper extends DrivingDocumentHelper
{
    public function execute()
    {
        $this->checkDateCoherence();
        $this->checkSameDocument();
        $this->executed = 1;
    }

    public function checkSameDocument()
    {
        $document = $this->em->getRepository(DrivingLicense::class)->findOneBy(array('number' => $this->instance->getNumber()));
        if($document == null) return true;
        $this->errors .= 'Esiste già una patente con questo numero<br>';
        return false;
    }
}