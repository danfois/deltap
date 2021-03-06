<?php

namespace AppBundle\Helper\Salary;

use AppBundle\Entity\Salary\Salary;
use AppBundle\Entity\Salary\SalaryDetail;
use AppBundle\Helper\AbstractHelper;
use AppBundle\Helper\Payment\PaymentHelper;
use Doctrine\ORM\EntityManager;

class SalaryHelper extends AbstractHelper
{
    public function __construct(Salary $salary, EntityManager $em, bool $isEdited = false)
    {
        $this->instance = $salary;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        if($this->isEdited === false) $this->checkExistingSalary();
        $this->iterateDetails();
        $this->executed = 1;
    }

    protected function checkExistingSalary()
    {
        $salary = $this->em->getRepository(Salary::class)->findOneBy(array('employee' => $this->instance->getEmployee(), 'year' => $this->instance->getYear(), 'month' => $this->instance->getMonth()));
        if($salary == null) return true;
        $this->errors .= 'Esiste già uno stipendio per ' . $this->instance->getEmployee()->getName() . ' ' . $this->instance->getEmployee()->getSurname() . ' per il mese ' . $this->instance->getMonth() . '/' . $this->instance->getYear();
        return false;
    }

    public function removeOldPayments($oldDetails)
    {
        $newDetails = array();
        foreach($this->instance->getSalaryDetails() as $d) {
            $newDetails[] = $d->getSalaryDetailId();
        }

        foreach($oldDetails as $k => $od) {
            if(in_array($od, $newDetails) === false) {
                $detail = $this->em->getRepository(SalaryDetail::class)->find($od);
                $this->em->remove($detail);
            }
        }
    }

    protected function compilePayments($detail)
    {
        if($detail instanceof SalaryDetail) {

            $payment = $detail->getPayment();
            $payment->setDirection('OUT');
            $payment->setEmployee($this->instance->getEmployee());


            $PH = new PaymentHelper($payment, $this->em, $this->isEdited);
            $PH->execute();
            $this->errors .= $PH->getErrors();

        }
    }

    protected function iterateDetails()
    {
        if($this->instance instanceof Salary) {
            foreach ($this->instance->getSalaryDetails() as $d) {
                $d->setSalary($this->instance);
                $this->compilePayments($d);
            }
        }
    }
}