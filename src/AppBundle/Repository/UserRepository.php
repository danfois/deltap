<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findWithEmployee()
    {
        $query = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.employee IS NOT NULL')
            ->getQuery();

        return $query->getResult();
    }
}