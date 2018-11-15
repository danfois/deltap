<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\PriceQuotation\Demand;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DemandNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Demand) {

                $r[] = [
                    'id' => $o->getDemandId(),
                    'ids' => $o->getDemandId(),
                    'idv' => $o->getDemandId(),
                    'priceQuotation' => ($o->getPriceQuotation() != null ? $o->getPriceQuotation()->getCode() : ''),
                    'demandDateTime' => $o->getDemandDateTime()->format('d-m-Y H:i'),
                    'requestedBy' => $o->getRequestedBy(),
                    'receiver' => $o->getReceiver()->getUsername(),
                    'demandType' => $o->getDemandType(),
                    'subject' => $o->getSubject()
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