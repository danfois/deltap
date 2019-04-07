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

                if(count($o->getPriceQuotationDetails()) == 0 ) {
                    $status = 5;
                } else {
                    $status = $o->getStatus();
                }

                $r[] = [
                    'id' => $o->getPriceQuotationId(),
                    'idv' => $o->getPriceQuotationId(),
                    'ids' => $o->getPriceQuotationId(),
                    'code' => substr($o->getCode(), 5),
                    'customer' => $o->getCustomer()->getBusinessName(),
                    'author' => $o->getAuthor()->getUsername(),
                    'status' => $status,
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