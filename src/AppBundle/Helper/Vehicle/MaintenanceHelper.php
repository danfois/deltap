<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\Maintenance;
use AppBundle\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;

class MaintenanceHelper extends AbstractHelper
{
    public function __construct(Maintenance $instance, EntityManager $em, bool $isEdited)
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
        foreach($this->instance->getMaintenanceDetails() as $d) {
            $d->setMaintenance($this->instance);
            $DH = new MaintenanceDetailHelper($d, $this->em, $this->isEdited);
            $DH->execute();
            $this->errors .= $DH->getErrors();
            //controllare se sta parte da errore
        }
    }


}