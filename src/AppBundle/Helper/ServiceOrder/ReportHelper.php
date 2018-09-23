<?php

namespace AppBundle\Helper\ServiceOrder;

use AppBundle\Entity\ServiceOrder\Report;
use Doctrine\ORM\EntityManager;

class ReportHelper
{
    protected $report;
    protected $em;
    protected $errors;
    protected $executed = 0;
    protected $isEdited;

    public function __construct(Report $report, EntityManager $em, bool $isEdited = false)
    {
        $this->report = $report;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        if($this->isEdited === false) {
            $this->setValidation();
        }
        $this->checkKm();
        $this->setTotalKm();
        $this->executed = 1;
    }

    protected function checkKm()
    {
        if($this->report->getStartKm() > $this->report->getEndKm()) {
            $this->errors .= 'I chilometri di partenza sono superiori a quelli di arrivo<br>';
            return false;
        }
        return true;
    }

    protected function setTotalKm()
    {
        $totalKm = $this->report->getEndKm() - $this->report->getStartKm();
        if($this->report->setTotalKm($totalKm)) return true;
        $this->errors .= 'Impossibile impostare i chilometri totali<br>';
        return false;
    }

    protected function setValidation()
    {
        if($this->report->setValidated(0)) return true;
        $this->errors .= 'Impossibile impostare lo stato di validità del report<br>';
        return false;
    }

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not Executed');
        return $this->errors;
    }
}