<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\Vehicle\Vehicle;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class VehicleViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Vehicle) {
                $r[] = [
                    'id'            => $o->getVehicleId(),
                    'idv'           => $o->getVehicleId(),
                    'plate'         => $o->getPlate(),
                    'brand'         => $o->getBrand(),
                    'model'         => $o->getModel(),
                    'seats'         => $o->getSeats(),
                    'stands'        => $o->getStands(),
                    'owner'         => $o->getOwner(),
                    'use'           => $o->getUseTypology(),
                    'purchaseDate'  => $o->getPurchaseDate()->format('d/m/Y')
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