<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\MaintenanceDetail;
use AppBundle\Entity\Vehicle\MaintenanceType;
use AppBundle\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;

class MaintenanceDetailHelper extends AbstractHelper
{
    protected $maintenanceType;

    public function __construct(MaintenanceDetail $instance, EntityManager $em, bool $isEdited)
    {
        $this->instance = $instance;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        if($this->checkIfHasMaintenance() == false) {
            $this->executed = 1;
            return false;
        }
        $this->getMaintenanceType();
        $this->completeKm();
        $this->completeDate();
        $this->setTotalAmount();
        $this->executed = 1;
    }

    protected function getMaintenanceType()
    {
        if($this->instance->getMaintenanceType() == null) {
            $this->errors .= 'Non hai selezionato nessun tipo manutenzione<br>';
            return false;
        }

        $mt = $this->em->getRepository(MaintenanceType::class)->find($this->instance->getMaintenanceType());

        if($mt == null) {
            $this->errors .= 'Errore durante la selezione del tipo di manutenzione. Non esiste nel database<br>';
            return false;
        }

        $this->maintenanceType = $mt;
        return true;
    }

    protected function checkIfHasMaintenance()
    {
        if($this->instance->getMaintenance() == null) {
            $this->errors .= 'I dettagli non sono stati associati alla scheda manutenzione<br>';
            return false;
        }
        return true;
    }

    protected function completeKm()
    {
        if($this->maintenanceType->getKmInterval() == null) return true;

        if($this->instance->getMaintenance()->getStartKm() == null) {
            $this->errors .= 'Non hai inserito il chilometraggio iniziale del veicolo<br>';
            return false;
        }

        $this->instance->setExpirationKm((int)$this->instance->getMaintenance()->getStartKm() + (int)$this->maintenanceType->getKmInterval());
        return true;
    }

    protected function completeDate()
    {
        if($this->maintenanceType->getDateInterval() == null) return true;

        if($this->instance->getMaintenance()->getStartDate() == null) {
            $this->errors .= 'Non hai inserito la data di esecuzione della manutenzione<br>';
            return false;
        }

        $startDate = clone $this->instance->getMaintenance()->getStartDate();

        $this->instance->setExpirationDate($startDate->modify($this->maintenanceType->getDateInterval()));
        return true;
    }

    protected function setTotalAmount()
    {
        $vat = $this->instance->getVat();
        $amount = $this->instance->getAmount();

        if($vat == null || $amount == null) {
            $this->errors .= 'Iva e importo non sono stati impostati correttamente<br>';
            return false;
        }

        $this->instance->setTotalAmount(
            (float) ((float) $amount + (($amount / 100) * $vat))
        );
        return true;
    }
}