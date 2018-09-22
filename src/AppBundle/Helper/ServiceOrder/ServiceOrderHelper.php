<?php

namespace AppBundle\Helper\ServiceOrder;

use AppBundle\Entity\ServiceOrder\ServiceOrder;
use Doctrine\ORM\EntityManager;

class ServiceOrderHelper
{
    protected $serviceOrder;
    protected $em;
    protected $errors;
    protected $executed = 0;
    protected $isEdited;

    public function __construct(ServiceOrder $serviceOrder, EntityManager $entityManager, bool $isEdited = false)
    {
        $this->serviceOrder = $serviceOrder;
        $this->em = $entityManager;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->executed = 1;
    }

    protected function checkVehicleAvailability()
    {
        //todo: implement that function
        return true;
    }

    public function getErrors()
    {
        if ($this->executed === 0) throw new \Exception('Class not executed');
        return $this->errors;
    }

}