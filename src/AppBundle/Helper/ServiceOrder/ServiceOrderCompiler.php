<?php

namespace AppBundle\Helper\ServiceOrder;

use AppBundle\Entity\PriceQuotation\Stage;
use AppBundle\Entity\RepeatedTimes;
use AppBundle\Entity\ServiceOrder\ServiceOrder;

class ServiceOrderCompiler
{
    protected $stage;
    protected $repeatedTime;
    protected $serviceOrder;

    public function __construct(Stage $stage, RepeatedTimes $repeatedTime)
    {
        $this->stage = $stage;
        $this->repeatedTime = $repeatedTime;
    }

    public function compileOrder()
    {
        $this->serviceOrder = new ServiceOrder();

        if ($this->stage->getPriceQuotationDetail() == null) throw new \Exception('Impossibile emettere ordine di servizio per tragitto senza itinerario');

        $this->setCustomer();
        $this->setPriceQuotation();
        $this->setPriceQuotationDetail();
        $this->setStage();
        $this->setDepartureLocation();
        $this->setArrivalLocation();
        $this->setDepartureDate();
        $this->setArrivalDate();
        $this->setDescription();
        $this->setPassengers();
        $this->setPrice();
        $this->setServiceFrequency();
        $this->setService();
    }

    public function getOrder(): ServiceOrder
    {
        return $this->serviceOrder;
    }

    protected function setCustomer()
    {
        $customer = $this->stage->getPriceQuotationDetail()->getPriceQuotation()->getCustomer();

        if ($this->serviceOrder->setCustomer($customer)) {
            return true;
        }

        throw new \Exception('Impossibile impostare l\'utente per questo Ordine di Servizio');
    }

    protected function setPriceQuotation()
    {
        if($this->stage->getPriceQuotationDetail()->getPriceQuotation() == null) throw new \Exception('Impossibile emettere ordine di servizio per un itinerario senza preventivo');
        if($this->serviceOrder->setPriceQuotation($this->stage->getPriceQuotationDetail()->getPriceQuotation())) return true;
        throw new \Exception('Impossibile associare l\'ordine di servizio ad un preventivo');
    }

    protected function setPriceQuotationDetail()
    {
        if($this->serviceOrder->setPriceQuotationDetail($this->stage->getPriceQuotationDetail())) return true;
        throw new \Exception("Impossibile associare l'itinerario all'ordine di servizio");
    }

    protected function setStage()
    {
        if($this->serviceOrder->setStage($this->stage)) return true;
        throw new \Exception("Impossibile associare l'ordine di servizio al suo tragitto");
    }

    protected function setDepartureLocation()
    {
        if($this->serviceOrder->setDepartureLocation($this->stage->getDepartureLocation())) return true;
        throw new \Exception("Impossibile stabilire la località di partenza");
    }

    protected function setArrivalLocation()
    {
        if($this->serviceOrder->setArrivalLocation($this->stage->getArrivalLocation())) return true;
        throw new \Exception("Impossibile stabilire la località di arrivo");
    }

    protected function setDepartureDate()
    {
        if($this->serviceOrder->setDepartureDate($this->stage->getDepartureDate())) return true;
        throw new \Exception("Impossibile stabilire la data di partenza");
    }

    protected function setArrivalDate()
    {
        if($this->serviceOrder->setArrivalDate($this->stage->getArrivalDate())) return true;
        throw new \Exception("Impossibile stabilire la data di arrivo");
    }

    protected function setDescription()
    {
        if($this->stage->getPriceQuotationDetail()->getDescription() != null) {
            $this->serviceOrder->setDescription($this->stage->getPriceQuotationDetail()->getDescription());
        }
    }

    protected function setPassengers()
    {
        if($this->stage->getPassengers() != null) {
            $this->serviceOrder->setPassengers($this->stage->getPassengers());
        }
        return true;
    }

    protected function setPrice()
    {
        if($this->stage->getPrice() != null) {
            $this->serviceOrder->setPrice($this->stage->getPrice());
        }
        return true;
    }

    protected function setServiceFrequency()
    {
        $serviceFrequency = $this->stage->getPriceQuotationDetail()->getServiceType();
        if($serviceFrequency == null) throw new \Exception("Impossibile impostare la frequenza del servizio per questo ordine di servizio");
        $this->serviceOrder->setServiceFrequency($serviceFrequency);
        return true;
    }

    protected function setService()
    {
        $service = $this->stage->getPriceQuotationDetail()->getServiceCode();
        if($service == null) throw new \Exception("Impossibile impostare il tipo di servizio per questo ordine di servizio");
        $this->serviceOrder->setService($service);
        return true;
    }

}