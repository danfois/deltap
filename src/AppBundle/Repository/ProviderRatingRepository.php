<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ProviderRatingRepository extends EntityRepository
{
    public function getRatingsByProvider(int $providerId)
    {
        $query = $this->createQueryBuilder('r')
            ->select('r, i')
            ->leftJoin('r.invoice', 'i')
            ->where('i.provider = :p')
            ->setParameter(':p', $providerId)
            ->getQuery();
        return $query->getResult();
    }
}