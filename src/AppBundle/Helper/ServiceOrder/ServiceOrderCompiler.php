<?php

namespace AppBundle\Helper\ServiceOrder;

use AppBundle\Entity\PriceQuotation\Stage;
use AppBundle\Entity\RepeatedTimes;
use AppBundle\Entity\ServiceOrder\ServiceOrder;

class ServiceOrderCompiler
{
    protected $stage;
    protected $repeatedTime;
    protected $date;
    protected $serviceOrder;

    public function __construct(Stage $stage, $repeatedTime, \DateTime $date = null)
    {
        $this->stage = $stage;
        $this->repeatedTime = $repeatedTime;
        $this->date = $date;
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
        $this->setStartTime();
        $this->setEndTime();
        $this->setDescription();
        $this->setPassengers();
        $this->setPrice();
        $this->setServiceFrequency();
        $this->setService();
        $this->setStatus();
        $this->setMap();
        $this->setVat();
    }

    public function getOrder(): ServiceOrder
    {
        return $this->serviceOrder;
    }

    protected function setVat()
    {
        if($this->serviceOrder->setVat($this->stage->getPriceQuotationDetail()->getVat())) return true;
        throw new \Exception('Impossibile impostare la percentuale IVA');
    }

    protected function setMap()
    {
        if($this->stage->getDirectionsLink() != null) {
            if($this->serviceOrder->setDirectionsLink($this->stage->getDirectionsLink())) return true;
            throw new \Exception("Impossibile impostare la mappa dell'Ordine di Servizio");
        }
        return false;
    }

    protected function setStatus()
    {
        if($this->serviceOrder->setStatus(1)) return true;
        throw new \Exception("Impossibile impostare lo status dell'Ordine di Servizio");
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
        ($this->date === null ? $date = $this->stage->getDepartureDate() : $date = $this->date);

        if($this->serviceOrder->setDepartureDate($date)) return true;
        throw new \Exception("Impossibile stabilire la data di partenza");
    }

    protected function setArrivalDate()
    {
        ($this->date === null ? $date = $this->stage->getArrivalDate() : $date = $this->date);

        if($this->serviceOrder->setArrivalDate($date)) return true;
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

    protected function setStartTime()
    {
        if($this->serviceOrder->setStartTime($this->repeatedTime['start_time'])) return true;
        throw new \Exception("Impossibile impostare l'orario di partenza per questo ordine di servizio");
    }

    protected function setEndTime()
    {
        if($this->serviceOrder->setEndTime($this->repeatedTime['end_time'])) return true;
        throw new \Exception("Impossibile impostare l'orario di arrivo per questo ordine di servizio");
    }

}