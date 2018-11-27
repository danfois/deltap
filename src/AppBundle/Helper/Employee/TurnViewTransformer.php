<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\EmployeeTurn;
use AppBundle\Entity\Employee\EmployeeTurnDetail;

class TurnViewTransformer
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

        foreach ($this->turns as $t) {
            if ($t instanceof EmployeeTurn)
                foreach ($t->getTurnDetails() as $td) {
                    if ($td instanceof EmployeeTurnDetail) {
                        if (!in_array($td->getEmployee()->getEmployeeId(), $driverArray)) {
                            $driverArray[$td->getEmployee()->getEmployeeId()] = array('name' => $td->getEmployee()->getName() . ' ' . $td->getEmployee()->getSurname(), 'turns' => array());
                        } else {
                            continue;
                        }
                    }
                }
        }

        return $driverArray;
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

                        $drivers[$employeeId]['turns'][] = $turnArray;

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