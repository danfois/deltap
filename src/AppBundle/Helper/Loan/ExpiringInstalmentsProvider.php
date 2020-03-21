<?php

namespace AppBundle\Helper\Loan;

use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Loan\LoanInstalment;
use Doctrine\ORM\EntityManager;

class ExpiringInstalmentsProvider
{
    protected $loans;
    protected $em;
    protected $preparedData;

    public function __construct(EntityManager $entityManager, $loans)
    {
        $this->em = $entityManager;
        $this->loans = $loans;
    }

    public function prepareData()
    {
        $timeToAdd = array(
        'MONTHLY' => '+1 month',
        'QUARTERLY' => '+3 months',
        'HALFYEARLY' => '+6 months',
        'YEARLY' => '+1 year'
        );

        foreach($this->loans as $l) {
            if($l instanceof Loan) {
                if(count($l->getLoanInstalments()) >= $l->getInstalmentNumber()) continue;
                $lastInstalment = $this->getLastInstalment($l);
                if($lastInstalment == null) {
                    $lastInstalment = new LoanInstalment();
                    $lastInstalment->setPaymentDate($l->getFirstInstalmentDate());
                }
                $this->preparedData[] = array(
                    'loan' => $l,
                    'lastInstalment' => $lastInstalment != null ? $lastInstalment->setPaymentDate($lastInstalment->getPaymentDate()->modify($timeToAdd[$l->getInstalmentType()])) : null
                );
            }
        }
        return $this;
    }

    public function getPreparedData()
    {
        return $this->preparedData;
    }

    protected function getOnlyUnpaidInstalments(array $instalments) : array
    {
        return array_filter($instalments, [$this, 'filter_by_payment_status']);
    }

    private function filter_by_payment_status($instalment)
    {
        return $instalment->getPayment() ? false : true;
    }

    protected function getLastInstalment(Loan $loan)
    {
        $instalments = $this->getOnlyUnpaidInstalments($loan->getLoanInstalments()->getValues());

        usort($instalments, function(LoanInstalment $a, LoanInstalment $b) {
            return  $a->getPaymentDate() < $b->getPaymentDate() ? -1 : 1;
        });

        return array_pop($instalments);
    }

}