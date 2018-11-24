<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\EmployeeTurn;
use AppBundle\Helper\AbstractHelper;
use Doctrine\ORM\EntityManagerInterface;

class TurnHelper extends AbstractHelper
{
    public function __construct(EmployeeTurn $instance, EntityManagerInterface $em, bool $isEdited)
    {
        $this->instance = $instance;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->iterateDetails();
        $this->executed = 1;
    }

    protected function iterateDetails()
    {
        foreach($this->instance->getTurnDetails() as $d) {
            $DH = new TurnDetailHelper($d, $this->em, $this->isEdited);
            $DH->execute();
            $this->errors .= $DH->getErrors();
            $DH = null;
        }
    }
}