<?php

namespace AppBundle\Service\Invoice;

use AppBundle\Entity\Invoice\InvoiceDetail;
use AppBundle\Entity\Invoice\InvoiceDetailInterface;

class InvoiceDetailInterfaceTransformer
{
    protected $data;
    protected $invoiceDetail;
    protected $transformed = 0;

    public function __construct(InvoiceDetailInterface $data = null)
    {
        $this->data = $data;
        $this->invoiceDetail = new InvoiceDetail();
    }

    public function setData(InvoiceDetailInterface $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getInvoiceDetail() : InvoiceDetail
    {
        if($this->transformed === 0) throw new \Exception('Before using InvoiceDetailInterfaceTransformer::getInvoiceDetail() you have to call ::transform().');
        return $this->invoiceDetail;
    }

    public function transform()
    {
        $this->invoiceDetail = new InvoiceDetail();

        $this
            ->setVat()
            ->setProductCode()
            ->setProductName()
            ->setInvoicePrice();

        $this->transformed = 1;

        return $this;
    }

    protected function setVat()
    {
        $vat = $this->data->getInvoiceVat();

        if($vat > 99) throw new \Exception('Vat is too high');
        if(!is_numeric($vat)) throw new \Exception('Vat is not a number. Check the data type');

        $this->invoiceDetail->setVat($vat);

        return $this;
    }

    protected function setProductName()
    {
        $pn = $this->data->getProductName();

        if($pn == null) throw new \Exception('Product Name is null');
        $this->invoiceDetail->setProductName($pn);

        return $this;
    }

    protected function setProductCode()
    {
        $pc = $this->data->getProductCode();

        if($pc == null) $pc = '000';
        $this->invoiceDetail->setProductCode($pc);

        return $this;
    }

    protected function setInvoicePrice()
    {
        $price = $this->data->getInvoicePrice();

        if(!is_numeric($price)) throw new \Exception('Price must be numeric');
        $this->invoiceDetail->setTotTaxExc($price);

        return $this;
    }
}