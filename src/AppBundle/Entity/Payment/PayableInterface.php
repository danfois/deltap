<?php

namespace AppBundle\Entity\Payment;

interface PayableInterface
{
    public function getPaymentDate();

    public function getDirection();

    public function getAmount();

    public function getCausal();

    public function getCustomer();

    public function getProvider();

    public function getIssuedInvoice();

    public function getReceivedInvoice();
}