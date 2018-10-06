<?php

namespace AppBundle\Service\Invoice;

use AppBundle\Entity\Invoice\Invoice;
use AppBundle\Entity\Invoice\InvoiceDetail;
use AppBundle\Entity\Invoice\InvoiceDetailInterface;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\ServiceOrder\ServiceOrder;

class InvoiceFormManager
{
    protected $invoice;
    protected $data;
    protected $transformer;

    public function __construct(Invoice $invoice, $data)
    {
        $this->invoice = $invoice;

        if(is_array($data) == true || $data instanceof InvoiceDetailInterface) {
            $this->data = $data;
        } else {
            throw new \Exception('Data should be array or instance of InvoiceDetailInterface');
        }

        $this->transformer = new InvoiceDetailInterfaceTransformer();
    }

    public function manageInvoiceData()
    {
        $this->iterateData();
        return $this;
    }

    protected function iterateData()
    {
        if(is_array($this->data)) {
            foreach($this->data as $d) {
                if($d instanceof PriceQuotation && $this->invoice instanceof IssuedInvoice) $this->invoice->setPriceQuotation($d);
                if($d instanceof ServiceOrder && $this->invoice instanceof IssuedInvoice) $this->invoice->setPriceQuotation($d->getPriceQuotation());
                $invoiceDetail = $this->transformData($d);
                $this->setInvoiceDetail($invoiceDetail);
                $invoiceDetail = null;
            }
            return true;
        }

        if($this->data instanceof PriceQuotation && $this->invoice instanceof IssuedInvoice) $this->invoice->setPriceQuotation($this->data);

        $invoiceDetail = $this->transformData($this->data);
        $this->setInvoiceDetail($invoiceDetail);

        return true;
    }

    protected function transformData($data)
    {
        $invoiceDetail = $this->transformer->setData($data)->transform()->getInvoiceDetail();

        return $invoiceDetail;
    }

    protected function setInvoiceDetail($detail)
    {
        if(!$detail instanceof InvoiceDetail) throw new \Exception('Cannot set Invoice Detail because a different class was provided');
        if($this->invoice->addInvoiceDetail($detail)) return true;
        throw new \Exception('Cannot assign detail to Invoice');
    }

    public function getInvoice() : Invoice
    {
        return $this->invoice;
    }
}