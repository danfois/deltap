<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Vehicle\MaintenanceType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MaintenanceTypeNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof MaintenanceType) {

                $r[] = [
                    'id' => $o->getMaintenanceTypeId(),
                    'ids' => $o->getMaintenanceTypeId(),
                    'idv' => $o->getMaintenanceTypeId(),
                    'name' => $o->getMaintenanceName(),
                    'dateInterval' => $o->getDateInterval(),
                    'kmInterval' => $o->getKmInterval()
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