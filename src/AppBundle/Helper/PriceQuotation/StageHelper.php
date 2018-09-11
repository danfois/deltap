<?php

namespace AppBundle\Helper\PriceQuotation;

use AppBundle\Entity\PriceQuotation\Stage;
use AppBundle\Entity\RepeatedTimes;
use Doctrine\ORM\EntityManager;

class StageHelper
{
    protected $stage;
    protected $em;
    protected $executed;
    protected $isEdited;
    protected $errors;

    public function __construct(Stage $stage, EntityManager $em, bool $isEdited = false)
    {
        $this->stage = $stage;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->checkDateCoherence();
        $this->checkTimeCoherence();
        $this->executed = 1;
    }

    public function getErrors()
    {
        if ($this->executed === 0) throw new \Exception('Class not executed - StageHelper::getErrors()');
        return $this->errors;
    }

    protected function checkDateCoherence()
    {
        if ($this->stage->getDepartureDate() < $this->stage->getArrivalDate()) return true;
        $this->errors .= 'La data di partenza non può essere successiva a quella di arrivo<br>';
        return false;
    }

    protected function checkTimeCoherence()
    {
        $times = $this->stage->getRepeatedTimes();

        foreach ($times as $t) {
            if ($t->getStartTime() > $t->getEndTime()) {
                $this->errors .= "L'Orario di partenza non può essere successivo a quello di arrivo<br>";
                return false;
            }
        }
        return true;
    }
}