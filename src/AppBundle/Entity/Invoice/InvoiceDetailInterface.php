<?php

namespace AppBundle\Entity\Invoice;

interface InvoiceDetailInterface
{
    public function getProductCode(): string;

    public function getProductName(): string;

    public function getPrice(): float;

    public function getVat();
}