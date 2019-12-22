<?php

namespace AppBundle\Service\EmployeeTurn;

use AppBundle\Entity\Employee\Employee;
use AppBundle\Entity\Employee\EmployeeTurn;
use AppBundle\Entity\Employee\EmployeeTurnDetail;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeTurnManager
{
    protected $em;
    protected $turn;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function generateYearlyTurns()
    {
        $startDate = \DateTime::createFromFormat('d-m-Y', '01-01-2019');
        $employees = $this->em->getRepository(Employee::class)->findAll();

        for($i = $startDate; $i < \DateTime::createFromFormat('d-m-Y', '31-12-2021'); $i->modify('+1 day'))
        {
            $turn = new EmployeeTurn();
            $turn->setTurnDate($i);
            $this->em->persist($turn);

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

    public function generateYearlyTurnsForEmployee(Employee $e) {
        $startDate = \DateTime::createFromFormat('d-m-Y', '01-01-2019');

        $turns = $this->em->getRepository(EmployeeTurn::class)->findAll();
        foreach($turns as $t) {
            $td = new EmployeeTurnDetail();
            $td->setEmployee($e);
            $td->setIllness(false);
            $td->setHoliday(false);
            $td->setTurn($t);
            $this->em->persist($td);
        }

        $this->em->flush();
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

    public function getTodayDriverTurn(User $user)
    {
        $turn = $this->em->getRepository(EmployeeTurn::class)->findOneBy(array('turnDate' => new \DateTime));
        $this->turn = $turn;

        if($turn == null) {
            $this->prepareTurn();

            $turn = $this->em->getRepository(EmployeeTurnDetail::class)->findOneBy(array('employee' => $user->getEmployee()->getEmployeeId(), 'turn' => $this->turn->getTurnId()));
            return $turn;
        }

        $turn = $this->em->getRepository(EmployeeTurnDetail::class)->findOneBy(array('employee' => $user->getEmployee()->getEmployeeId(), 'turn' => $this->turn->getTurnId()));
        return $turn;
    }
}