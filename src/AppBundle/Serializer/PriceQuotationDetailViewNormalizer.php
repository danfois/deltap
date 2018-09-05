<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PriceQuotationDetailViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof PriceQuotationDetail) {

                $r[] = [
                    'id' => $o->getPriceQuotationDetailId(),
                    'idv' => $o->getPriceQuotationDetailId(),
                    'ids' => $o->getPriceQuotationDetailId(),
                    'name' => $o->getName(),
                    'serviceType' => $o->getServiceType()->getServiceName(),
                    'serviceCode' => $o->getServiceCode()->getService()
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