<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ReceivedInvoiceSerializer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof ReceivedInvoice) {

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
                    'provider' => $o->getProvider()->getBusinessName(),
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