<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\EmployeeTurn;
use AppBundle\Entity\Employee\EmployeeTurnDetail;

class TurnViewProvider
{
    protected $turns;
    protected $transformedData;

    public function __construct(array $turns)
    {
        $this->turns = $turns;
    }

    protected function createDriversBidimensionalArray()
    {
        $driverArray = array();
        $daysArray = $this->getMonthDaysArray();

        foreach ($this->turns as $t) {
            if ($t instanceof EmployeeTurn)
                foreach ($t->getTurnDetails() as $td) {
                    if ($td instanceof EmployeeTurnDetail) {
                        if (!in_array($td->getEmployee()->getEmployeeId(), $driverArray)) {
                            $driverArray[$td->getEmployee()->getEmployeeId()] = array('name' => $td->getEmployee()->getName() . ' ' . $td->getEmployee()->getSurname(), 'turns' => $daysArray);
                        } else {
                            continue;
                        }
                    }
                }
        }
        return $driverArray;
    }

    protected function getMonthDaysArray()
    {
        $daysArray = array();

        if(count($this->turns) > 0) {
            if ($this->turns[0] != null) {
                $turn = $this->turns[0];
                if ($turn instanceof EmployeeTurn) {
                    $month = $turn->getTurnDate()->format('m');

                    switch ($month) {
                        case "01":
                        case "03":
                        case "05":
                        case "07":
                        case "08":
                        case "10":
                        case "12":
                            $daysNumber = 31;
                            break;
                        case "02":
                            $daysNumber = 29;
                            break;
                        case "04":
                        case "06":
                        case "09":
                        case "11":
                            $daysNumber = 30;
                            break;
                        default:
                            $daysNumber = 31;
                            break;
                    }

                    for ($i = 1; $i <= $daysNumber; $i++) {
                        $daysArray[$i] = array(
                            'date' => "",
                            'workingHours' => NULL,
                            'permissionTime' => NULL,
                            'illness' => NULL,
                            'holiday' => ""
                        );
                    }
                }
            }
        }

        return $daysArray;
    }

    public function prepareDataArray()
    {
        $drivers = $this->createDriversBidimensionalArray();

        foreach ($this->turns as $t) {

            if ($t instanceof EmployeeTurn)

                foreach ($t->getTurnDetails() as $td) {

                    if ($td instanceof EmployeeTurnDetail) {


                        $employeeId = $td->getEmployee()->getEmployeeId();

                        $turnArray = array(
                            'date' => $td->getTurn()->getTurnDate()->format('d-m-Y'),
                            'workingHours' => $td->getWorkingHours(),
                            'permissionTime' => $td->getPermissionTime(),
                            'illness' => $td->getIllness(),
                            'holiday' => $td->getHoliday()
                        );

                        $drivers[$employeeId]['turns'][(int)$td->getTurn()->getTurnDate()->format('d')] = $turnArray;
                    }
                }
        }

        $this->transformedData = $drivers;
        return $this;
    }

    public function getTransformedData()
    {
        return $this->transformedData;
    }
}