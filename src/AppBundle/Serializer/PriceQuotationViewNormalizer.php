<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\PriceQuotation\PriceQuotation;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PriceQuotationViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof PriceQuotation) {

                $r[] = [
                    'id' => $o->getPriceQuotationId(),
                    'idv' => $o->getPriceQuotationId(),
                    'ids' => $o->getPriceQuotationId(),
                    'code' => $o->getCode(),
                    'customer' => $o->getCustomer()->getBusinessName(),
                    'sender' => $o->getSenderMail(),
                    'recipient' => $o->getRecipientEmail(),
                    'service' => $o->getServiceCode()->getService(),
                    'author' => $o->getAuthor()->getUsername(),
                    'status' => $o->getStatus(),
                    'date' => $o->getPriceQuotationDate()->format('d-m-Y')
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