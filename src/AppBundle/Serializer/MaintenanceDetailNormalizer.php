<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Vehicle\MaintenanceDetail;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MaintenanceDetailNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof MaintenanceDetail) {

                $r[] = [
                    'id' => $o->getMaintenanceDetailId(),
                    'ids' => $o->getMaintenanceDetailId(),
                    'idv' => $o->getMaintenanceDetailId(),
                    'maintenanceType' => $o->getMaintenanceType()->getMaintenanceName(),
                    'description' => $o->getDescription(),
                    'amount' => $o->getTotalAmount(),
                    'expirationDate' => ($o->getExpirationDate() != null ? $o->getExpirationDate()->format('d-m-Y') : ''),
                    'expirationKm' => $o->getExpirationKm()
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