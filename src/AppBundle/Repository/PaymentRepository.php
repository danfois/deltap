<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository
{
    public function findTotalOutgoingBankMoney()
    {
        $query = $this->createQueryBuilder('p')
            ->select('SUM(p.amount)')
            ->where('p.paymentType != :type AND p.direction = :direction')
            ->setParameter(':type','CASH')
            ->setParameter(':direction','OUT')
            ->getQuery();
        return $query->getSingleScalarResult();
    }

    public function findTotalIncomeBankMoney()
    {
        $query = $this->createQueryBuilder('p')
            ->select('SUM(p.amount)')
            ->where('p.paymentType != :type AND p.direction = :direction')
            ->setParameter(':type','CASH')
            ->setParameter(':direction','IN')
            ->getQuery();
        return $query->getSingleScalarResult();
    }

    public function findTotalOutgoingCashMoney()
    {
        $query = $this->createQueryBuilder('p')
            ->select('SUM(p.amount)')
            ->where('p.paymentType = :type AND p.direction = :direction')
            ->setParameter(':type','CASH')
            ->setParameter(':direction','OUT')
            ->getQuery();
        return $query->getSingleScalarResult();
    }

    public function findTotalincomeCashMoney()
    {
        $query = $this->createQueryBuilder('p')
            ->select('SUM(p.amount)')
            ->where('p.paymentType = :type AND p.direction = :direction')
            ->setParameter(':type','CASH')
            ->setParameter(':direction','IN')
            ->getQuery();
        return $query->getSingleScalarResult();
    }
}