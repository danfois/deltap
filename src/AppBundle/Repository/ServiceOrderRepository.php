<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ServiceOrderRepository extends EntityRepository
{
    public function findDriverNewOrders($user, $date, $status)
    {
        $date = $date->format('Y-m-d');

        $query = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.driver = :user AND s.departureDate LIKE :date AND s.status = :status')
            ->setParameter(':user', $user)
            ->setParameter(':date', $date . '%')
            ->setParameter(':status', $status)
            ->orderBy('s.startTime')
            ->getQuery();

        return $query->getResult();
    }

    public function findDriverFutureOrders($user, $date, $status)
    {
        $date = $date->format('Y-m-d');

        $query = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.driver = :user AND s.departureDate > :date AND s.status = :status')
            ->setParameter(':user', $user)
            ->setParameter(':date', $date)
            ->setParameter(':status', $status)
            ->orderBy('s.departureDate, s.startTime')
            ->getQuery();

        return $query->getResult();
    }

    public function findDriverOldOrders($user, $date)
    {
        $query = $this->createQueryBuilder('s')
            ->select('s')
            ->leftJoin('s.report', 'r')
            ->where('s.driver = :user AND s.arrivalDate < :date AND r.reportId IS NOT NULL')
            ->setParameter(':user', $user)
            ->setParameter(':date', $date)
            ->orderBy('s.departureDate, s.startTime')
            ->getQuery();

        return $query->getResult();
    }

    public function findDriverToReportOrders($user, $date)
    {
        $query = $this->createQueryBuilder('s')
            ->select('s')
            ->leftJoin('s.report', 'r')
            ->where('s.driver = :user AND s.departureDate < :date AND r.reportId IS NULL')
            ->setParameter(':user', $user)
            ->setParameter(':date', $date)
            ->orderBy('s.departureDate, s.startTime')
            ->getQuery();

        return $query->getResult();
    }

    public function findServiceOrdersInArray($inArray)
    {
        $query = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.serviceOrder IN (:inarray)')
            ->setParameter(':inarray', $inArray)
            ->getQuery();

        return $query->getResult();
    }


}