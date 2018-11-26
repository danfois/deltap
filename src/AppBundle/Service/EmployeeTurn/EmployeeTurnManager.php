<?php

namespace AppBundle\Service\EmployeeTurn;

use AppBundle\Entity\Employee\Employee;
use AppBundle\Entity\Employee\EmployeeTurn;
use AppBundle\Entity\Employee\EmployeeTurnDetail;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeTurnManager
{
    protected $em;
    protected $turn;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getTodayTurn()
    {
        $turn = $this->em->getRepository(EmployeeTurn::class)->findOneBy(array('turnDate' => new \DateTime));
        if($turn == null) {
            $this->prepareTurn();
            return $this->turn;
        }
        return $turn;
    }

    protected function prepareTurn()
    {
        $turn = new EmployeeTurn();
        $turn->setTurnDate(new \DateTime());
        $this->em->persist($turn);

        $employees = $this->em->getRepository(Employee::class)->findAll();

        foreach($employees as $e) {
            $td = new EmployeeTurnDetail();
            $td->setEmployee($e);
            $td->setIllness(false);
            $td->setHoliday(false);
            $td->setTurn($turn);
            $this->em->persist($td);
        }

        $this->em->flush();
        $this->turn = $turn;
    }
}