<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Payment\Payment;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaymentNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Payment) {

                $r[] = [
                    'id' => $o->getPaymentId(),
                    'ids' => $o->getPaymentId(),
                    'idv' => $o->getPaymentId(),
                    'paymentDate' => $o->getPaymentDate()->format('d-m-Y'),
                    'direction' => $o->getDirection(),
                    'type' => $o->getPaymentType(),
                    'amount' => $o->getAmount(),
                    'causal' => $o->getCausal(),
                    'description' => $o->getDescription(),
                    'checkDate' => $o->getCheckDate(),
                    'checkNumber' => $o->getCheckNumber(),
                    'customer' => ($o->getCustomer() != null ? $o->getCustomer()->getBusinessName() : ''),
                    'provider' => ($o->getProvider() != null ? $o->getProvider()->getBusinessName() : '')
                ];
            }
        }

        return $r;
    }

    public function supportsNormalization($data, $format = null)
    {
        return true;
    }
}