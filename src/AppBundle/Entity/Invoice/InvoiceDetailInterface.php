<?php

namespace AppBundle\Entity\Invoice;

interface InvoiceDetailInterface
{
    public function getProductCode(): string;

    public function getProductName(): string;

    public function getInvoicePrice(): float;

    public function getInvoiceVat();

    public function getInvoiceCustomer();
}