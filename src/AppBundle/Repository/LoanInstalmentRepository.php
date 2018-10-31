<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LoanInstalmentRepository extends EntityRepository
{
public function findLoanInstalmentsInArray($inArray) {
    $query = $this->createQueryBuilder('i')
        ->select('i')
        ->where('i.loanInstalmentId IN (:inarray)')
        ->setParameter(':inarray', $inArray)
        ->getQuery();

    return $query->getResult();
}

}