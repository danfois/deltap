<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Vehicle\Maintenance;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MaintenanceNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Maintenance) {

                $r[] = [
                    'id' => $o->getMaintenanceId(),
                    'ids' => $o->getMaintenanceId(),
                    'idv' => $o->getMaintenanceId(),
                    'vehicle' => $o->getVehicle()->getPlate(),
                    'provider' => $o->getProvider()->getBusinessName(),
                    'employee' => ($o->getEmployee() != null ? $o->getEmployee()->getName() . ' ' . $o->getEmployee()->getSurname() : ''),
                    'km' => $o->getStartKm(),
                    'startDate' => $o->getStartDate()->format('d-m-Y'),
                    'invoice' => ($o->getInvoice() != null ? $o->getInvoice()->getInvoiceId() : '')
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