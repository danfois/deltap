<?php

namespace AppBundle\Helper\Payment;

use AppBundle\Entity\Payment\PayableInterface;
use AppBundle\Entity\Payment\Payment;

class PaymentCompiler
{
    protected $instance;
    protected $payment;

    public function __construct(PayableInterface $instance)
    {
        $this->instance = $instance;
        $this->payment = new Payment();
    }

    public function compile()
    {
        $this->payment->setPaymentDate($this->instance->getPaymentDate());
        $this->payment->setDirection($this->instance->getDirection());
        $this->payment->setAmount($this->instance->getAmount());
        $this->payment->setCausal($this->instance->getCausal());
        $this->payment->setCustomer($this->instance->getCustomer());
        $this->payment->setProvider($this->instance->getProvider());
        $this->payment->setIssuedInvoice($this->instance->getIssuedInvoice());
        $this->payment->setReceivedInvoice($this->instance->getReceivedInvoice());
        return $this;
    }

    public function getPayment()
    {
        return $this->payment;
    }
}