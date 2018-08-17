<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Vehicle\CarReview;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CarReviewViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof CarReview) {

                $status = '1';
                if(new \DateTime() > $o->getEndDate()) $status = '2';
                else if(new \DateTime('+1 month') > $o->getEndDate()) $status = '3';

                $r[] = [
                    'id'        => $o->getCarReviewId(),
                    'idv'       => $o->getCarReviewId(),
                    'startDate' => $o->getStartDate()->format('d/m/Y'),
                    'endDate'   => $o->getEndDate()->format('d/m/Y'),
                    'price'     => $o->getPrice(),
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