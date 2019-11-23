<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Invoice\IssuedInvoice;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class IssuedInvoiceSerializer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof IssuedInvoice) {

                $totTaxInc = 0;

                $balance = 0;

                foreach($o->getPayments() as $p) {
                    $balance += $p->getAmount();
                }

                foreach($o->getInvoiceDetails() as $d) {
                    $totTaxInc = $totTaxInc + $d->getTotTaxInc();
                }

                $r[] = array(
                    'id' => $o->getInvoiceId(),
                    'ids' => $o->getInvoiceId(),
                    'idv' => $o->getInvoiceId(),
                    'number' => (string) $o->getInvoiceNumber(),
                    'payment' => (string) $o->getPaymentTerms(),
                    'paInvoiceNumber' => (string) $o->getPaInvoiceNumber(),
                    'customer' => $o->getCustomer()->getBusinessName(),
                    'totTaxInc' => (string) $totTaxInc,
                    'balance' => (string) $balance,
                    'remaining' => (string) $totTaxInc - $balance,
                    'proforma' => ($o->getIsProforma() != null ? '1' : '0')
                );
            }
        }

        return $r;
    }

    public function supportsNormalization($data, $format = null)
    {
        return true;
    }
}