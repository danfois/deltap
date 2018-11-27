<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EmployeeTurnRepository extends EntityRepository
{
    public function findTurnsInMonthAndYear($m, $y)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.turnDate BETWEEN :m AND :y')
            ->setParameter(':m', $m)
            ->setParameter(':y', $y)
            ->getQuery();

        return $query->getResult();
    }
}