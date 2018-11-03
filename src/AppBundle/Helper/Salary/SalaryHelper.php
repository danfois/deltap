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
        $this->iterateDetails();
        $this->executed = 1;
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