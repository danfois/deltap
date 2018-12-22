<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findWithEmployee()
    {
        $query = $this->createQueryBuilder('u')
            ->select('u')
            ->leftJoin('AppBundle\Entity\Employee\Employee', 'e', 'WITH', 'u.employee = e.employeeId')
            ->where('u.employee IS NOT NULL')
            ->orderBy('e.surname')
            ->getQuery();

        return $query->getResult();
    }
}