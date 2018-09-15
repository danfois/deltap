<?php

namespace AppBundle\Helper\ServiceOrder;

use AppBundle\Entity\PriceQuotation\Stage;

class ServiceOrderCreator
{
    protected $stage;
    protected $resultArray;
    protected $repeatedTimes;
    protected $repeatedDays;

    public function __construct(Stage $stage, array $resultArray)
    {
        $this->stage = $stage;
        $this->resultArray = $resultArray;
    }

    public function createOrdersAndPushInResultArray()
    {
        if($this->checkRepeatedDays() === true) $this->setRepeatedDays();
        $this->setRepeatedTimes();

    }

    protected function checkRepeatedDays()
    {
        if($this->stage->getDepartureDate() < $this->stage->getArrivalDate()) return true;
        return false;
    }

    protected function setRepeatedTimes()
    {
        $this->repeatedTimes = $this->stage->getRepeatedTimes();
    }

    protected function setRepeatedDays()
    {
        $this->repeatedDays = $this->stage->getRepeatedDays();
    }

    protected function createOrders()
    {
        foreach($this->repeatedTimes as $t) {
            $SOC = new ServiceOrderCompiler($this->stage, $t);
            $SOC->compileOrder();
            $order = $SOC->getOrder();
            $this->resultArray[] = $order;
        }

        /*
         * Continuare da qui. Devo fare anche l'iterazione per i vari giorni.
         * Ora stavo inserendo gli ordini di servizio nell'array dei risultati
         */
    }
}