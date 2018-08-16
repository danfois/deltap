<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\Insurance;
use Doctrine\ORM\EntityManager;

class InsuranceEditHelper extends InsuranceHelper
{
    public function __construct(Insurance $insurance, EntityManager $em)
    {
        parent::__construct($insurance, $em);
    }

    public function execute()
    {
        $this->setInsuranceStartDate();
        $this->setInsuranceEndDate();
        $this->checkDateCoherence();
        $this->executed = 1;
    }
}