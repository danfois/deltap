<?php

namespace AppBundle\Helper\Payment;

use AppBundle\Entity\Payment\Payment;
use AppBundle\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;

class PaymentHelper extends AbstractHelper
{

    public function __construct(Payment $payment, EntityManager $em, bool $isEdited = false)
    {
        $this->instance = $payment;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->checkCustomerOrProvider();
        $this->checkPaymentDirectionCoherence();
        $this->checkSingleInvoiceType();
        $this->validateCheckPaymentType();
        $this->checkInvoiceCoherence();
        $this->executed = 1;
    }

    protected function checkCustomerOrProvider()
    {
        if($this->instance->getCustomer() != null && $this->instance->getProvider() != null) {
            $this->errors .= 'Devi scegliere o un cliente, o un fornitore ma NON entrambi<br>';
            return false;
        }

        if($this->instance->getCustomer() == null && $this->instance->getProvider() == null) {
            $this->errors .= 'Non hai scelto ne un cliente ne un fornitore<br>';
            return false;
        }
        return true;
    }

    protected function checkPaymentDirectionCoherence()
    {
        if($this->instance->getDirection() === 'IN' && $this->instance->getCustomer() == null) {
            $this->errors .= 'Devi scegliere un cliente in caso di pagamento in entrata<br>';
            return false;
        }

        if($this->instance->getDirection() === 'OUT' && $this->instance->getProvider() == null) {
            $this->errors .= 'Devi sceglere un fornitore in caso di pagamento in uscita<br>';
            return false;
        }
        return true;
    }

    protected function checkSingleInvoiceType()
    {
        if($this->instance->getIssuedInvoice() != null && $this->instance->getReceivedInvoice() != null) {
            $this->errors .= 'Devi scegliere solamente un tipo di fattura da associare, non entrambe<br>';
            return false;
        }
        return true;
    }

    protected function validateCheckPaymentType()
    {
        if($this->instance->getPaymentType() === 'CHECK') {
            if($this->instance->getCheckDate() == null || $this->instance->getCheckNumber() == null) {
                $this->errors .= 'Devi compilare i campi "Numero Assegno" e "Data Assegno" se come metodo di pagamento scegli l\'Assegno<br>';
                return false;
            }
        } else {
            if($this->instance->getCheckDate() != null || $this->instance->getCheckNumber() != null) {
                $this->errors .= 'Se non hai scelto "Assegno" come tipologia di pagamento, devi lasciare vuoti i campi "Numero Assegno", e "Data Assegno"<br>';
                return false;
            }
        }
        return true;
    }

    protected function checkInvoiceCoherence()
    {
        if($this->instance->getIssuedInvoice() != null && $this->instance->getDirection() === 'OUT') {
            $this->errors .= 'Non puoi registrare un pagamento in uscita per una fattura emessa<br>';
            return false;
        }

        if($this->instance->getReceivedInvoice() != null && $this->instance->getDirection() === 'IN') {
            $this->errors .= 'Non puoi registrare un pagamento in entrata per una fattura ricevuta<br>';
            return false;
        }
        return true;
    }
}