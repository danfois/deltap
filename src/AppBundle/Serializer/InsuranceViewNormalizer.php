<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Vehicle\Insurance;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InsuranceViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Insurance) {

                $status = '1';
                if(new \DateTime() > $o->getEndDate()) $status = '2';
                if(new \DateTime('+1 month') > $o->getEndDate()) $status = '3';

                $r[] = [
                    'id'        => $o->getInsuranceId(),
                    'idv'       => $o->getInsuranceId(),
                    'company'   => $o->getCompany()->getBusinessName(),
                    'number'    => $o->getNumber(),
                    'startDate' => $o->getStartDate()->format('d/m/Y'),
                    'endDate'   => $o->getEndDate()->format('d/m/Y'),
                    'price'     => $o->getPrice(),
                    'flat'      => $o->getFlat(),
                    'vehicle'   => $o->getVehicle()->getPlate(),
                    'status'    => $status
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