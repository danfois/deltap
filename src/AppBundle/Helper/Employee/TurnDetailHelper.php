<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\EmployeeTurnDetail;
use AppBundle\Helper\AbstractHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class TurnDetailHelper extends AbstractHelper
{
    public function __construct(EmployeeTurnDetail $instance, EntityManagerInterface $em, bool $isEdited)
    {
        $this->instance = $instance;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public  function execute()
    {
        $this->checkTimeCoherence();
        $this->checkWorkingHours();
        $this->setWorkingHours();
        $this->checkIllnessOrHoliday();
        $this->executed = 1;
    }

    protected function checkIllnessOrHoliday()
    {
        if($this->instance->getIllness() === true && $this->instance->getHoliday() === true) {
            $this->errors .= 'Non puoi scegliere malattia e ferie contemporaneamente per ' . $this->instance->getEmployee()->getName() . ' ' . $this->instance->getEmployee()->getSurname() . '<br>';
            return false;
        }

        if($this->instance->getIllness() === true || $this->instance->getHoliday() === true) {
            $this->instance->setWorkingHours(null);
            $this->instance->setStartTime(null);
            $this->instance->setEndTime(null);
            $this->instance->setPermissionTime(null);
            return true;
        }
        return true;
    }

    protected function checkTimeCoherence()
    {
        $st = $this->instance->getStartTime();
        $et = $this->instance->getEndTime();

        if($st != null && $et != null) {
            if($st > $et) {
                $this->errors .= 'La data di inizio non può essere successiva a quella di fine per ' . $this->instance->getEmployee()->getName() . ' ' . $this->instance->getEmployee()->getSurname() . '<br>';
                return false;
            }
            return true;
        }
        return true;
    }

    protected function checkWorkingHours()
    {
        $st = $this->instance->getStartTime();
        $et = $this->instance->getEndTime();
        $wh = $this->instance->getWorkingHours();

        if($st != null && $et != null && $wh != null) {
            $itv = $et->diff($st);
            if($itv->format('%H,%I') != $wh->format('H,i')) {
                $this->errors .= 'Le ore lavorative non coincidono con la data di inizio e di fine per ' . $this->instance->getEmployee()->getName() . ' ' . $this->instance->getEmployee()->getSurname() . '<br>';
                return false;
            }
        }
        return true;
    }

    protected function setWorkingHours()
    {
        $st = $this->instance->getStartTime();
        $et = $this->instance->getEndTime();
        $wh = $this->instance->getWorkingHours();

        if($wh == null && $st != null && $et != null) {

            $itv = $et->diff($st);
            $itv->invert = 0;

            $dt = new \DateTime();
            $dt->setTime(0,0);

            $this->instance->setWorkingHours($dt->add($itv));
            return true;
        }
        return true;
    }
}