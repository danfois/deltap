<?php

namespace AppBundle\Helper\Customer;
use AppBundle\Entity\Customer;

class CustomerHelper
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function execute()
    {
        $this->setRegistrationDate();
    }

    private function setRegistrationDate()
    {
        if($this->customer->setRegistrationDate(new \DateTime())) return true;
        throw new \Exception('Cannot set registration date for the customer');
    }
}