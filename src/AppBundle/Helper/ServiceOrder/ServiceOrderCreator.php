<?php

namespace AppBundle\Helper\ServiceOrder;

use AppBundle\Entity\PriceQuotation\Stage;

class ServiceOrderCreator
{
    protected $stage;
    protected $resultArray;
    protected $repeatedTimes;
    protected $repeatedDays;

    public function __construct(Stage $stage)
    {
        $this->stage = $stage;
        $this->resultArray = array();
        $this->repeatedDays = array();
    }

    public function createOrdersAndPushInResultArray()
    {
        if ($this->checkRepeatedDays() === true) $this->setRepeatedDays();
        $this->setRepeatedTimes();
        $this->createOrders();
    }

    protected function checkRepeatedDays()
    {
        if ($this->stage->getDepartureDate() < $this->stage->getArrivalDate()) return true;
        return false;
    }

    protected function setRepeatedTimes()
    {
        $this->repeatedTimes = $this->stage->getRepeatedTimes();
    }

    /**
     * This function must create and set an array of dates.
     * It takes departure date of the stage and the arrival date, then
     * converts repeatedDays into weeks days
     */
    protected function setRepeatedDays()
    {
        $repeatedDays = $this->stage->getRepeatedDays();

        $startDate = $this->stage->getDepartureDate();
        $endDate = $this->stage->getArrivalDate();

        for($i = $startDate; $i <= $endDate; $i = $i->modify('+1 day')) {
            if(in_array($i->format('w'), $repeatedDays)) {
                $clonedDate = clone $i;
                $this->repeatedDays[] = $clonedDate;
            }
        }
        return true;
    }

    protected function createOrders()
    {
        if ($this->repeatedDays == null) {
            foreach ($this->repeatedTimes as $t) {
                $SOC = new ServiceOrderCompiler($this->stage, $t);
                $SOC->compileOrder();
                $order = $SOC->getOrder();
                $this->resultArray[] = $order;
                $SOC = null;
            }
            return true;
        } else {
            foreach ($this->repeatedDays as $d) {
                foreach ($this->repeatedTimes as $t) {
                    $SOC = new ServiceOrderCompiler($this->stage, $t, $d);
                    $SOC->compileOrder();
                    $order = $SOC->getOrder();
                    $this->resultArray[] = $order;
                    $SOC = null;
                }
            }
            return true;
        }
    }

    public function getResultArray()
    {
        return $this->resultArray;
    }
}