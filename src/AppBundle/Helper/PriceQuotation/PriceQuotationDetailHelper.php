<?php

namespace AppBundle\Helper\PriceQuotation;
use AppBundle\Entity\PriceQuotation;
use AppBundle\Entity\PriceQuotationDetail;
use Doctrine\Common\Collections\ArrayCollection;

class PriceQuotationDetailHelper
{
    private $priceQuotationDetails;
    private $priceQuotation;

    public function __construct(ArrayCollection $priceQuotationDetails, PriceQuotation $PQ)
    {
        $this->priceQuotationDetails = $priceQuotationDetails;
        $this->priceQuotation = $PQ;
    }

    public function execute()
    {
        $this->iterate();
    }

    private function convertDates(PriceQuotationDetail $pqd)
    {
        $pqd->setDepartureDate(new \DateTime($pqd->getDepartureDate()));
        $pqd->setArrivalDate(new \DateTime($pqd->getArrivalDate()));
    }

    private function setPriceQuotation(PriceQuotationDetail $pqd)
    {
        $pqd->setPriceQuotation($this->priceQuotation);
    }

    private function iterate()
    {
        foreach($this->priceQuotationDetails as $pqd) {
            $this->convertDates($pqd);
            $this->setPriceQuotation($pqd);
        }
    }


}