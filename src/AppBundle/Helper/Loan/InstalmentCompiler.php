<?php

namespace AppBundle\Helper\Loan;

use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Loan\LoanInstalment;

class InstalmentCompiler
{
    protected $loan;
    protected $instalment;
    protected $errors;

    public function __construct(Loan $loan, LoanInstalment $instalment = null)
    {
        $this->loan = $loan;
        $this->instalment = new LoanInstalment();
    }

    public function compile()
    {
        $interests = $this->calculateInterests();

        $this->instalment->setPaymentDate(new \DateTime());
        $this->instalment->setAmount($this->loan->getInstalmentAmount());
        $this->instalment->setCapital($this->loan->getInstalmentAmount() - $interests);
        $this->instalment->setInterests($interests);
        $this->instalment->setInterestRate($this->loan->getInterestRate());
        $this->instalment->setPaymentType($this->loan->getPaymentType());
        return $this;
    }

    protected function calculateInterests()
    {
        $interestRate = $this->loan->getInterestRate();
        $interests = ($this->loan->getInstalmentAmount() / 100) * $interestRate;

        return $interests;
    }

    public function getInstalment()
    {
        return $this->instalment;
    }
}