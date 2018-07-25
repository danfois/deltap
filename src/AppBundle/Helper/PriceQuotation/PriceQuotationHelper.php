<?php

namespace AppBundle\Helper\PriceQuotation;

use AppBundle\Entity\PriceQuotation;
use AppBundle\Entity\User;

class PriceQuotationHelper
{
    private $priceQuotation;
    private $user;
    private $_pqdh;

    public function __construct(PriceQuotation $priceQuotation, User $user)
    {
        $this->priceQuotation = $priceQuotation;
        $this->user = $user;
        $this->_pqdh = new PriceQuotationDetailHelper($this->priceQuotation->getQuotationDetails(), $this->priceQuotation);
    }

    public function execute()
    {
        $this->setUser();
        $this->setStatus();
        $this->convertDates();
        $this->_pqdh->execute();
    }

    private function setUser()
    {
        if($this->priceQuotation->setAuthor($this->user)) return true;
        throw new \Exception('Cannot set Price Quotation Author');
    }

    private function setStatus()
    {
        if($this->priceQuotation->setStatus(1)) return true;
        throw new \Exception('Cannot set Price Quotation Status');
    }

    private function convertStringToDate($string)
    {
        return new \DateTime($string);
    }

    private function convertDates()
    {
        if($this->priceQuotation->getQuotationDate() != '') {
            $this->priceQuotation->setQuotationDate($this->convertStringToDate($this->priceQuotation->getQuotationDate()));
        }
    }
}