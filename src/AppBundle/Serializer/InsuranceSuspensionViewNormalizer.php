<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Vehicle\InsuranceSuspension;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InsuranceSuspensionViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof InsuranceSuspension) {

                $r[] = [
                    'id'        => $o->getSuspensionId(),
                    'idv'       => $o->getSuspensionId(),
                    'startDate' => $o->getStartDate()->format('d/m/Y'),
                    'endDate'   => $o->getEndDate()->format('d/m/Y'),
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