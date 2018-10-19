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

                foreach($o->getInvoiceDetails() as $d) {
                    $totTaxInc = $totTaxInc + $d->getTotTaxInc();
                }

                $r[] = array(
                    'id' => $o->getInvoiceId(),
                    'ids' => $o->getInvoiceId(),
                    'idv' => $o->getInvoiceId(),
                    'number' => $o->getInvoiceNumber(),
                    'payment' => $o->getPaymentTerms(),
                    'paInvoiceNumber' => $o->getPaInvoiceNumber(),
                    'customer' => $o->getCustomer()->getBusinessName(),
                    'totTaxInc' => $totTaxInc
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