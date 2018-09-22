<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ServiceOrderViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof ServiceOrder) {

                $r[] = [
                    'id' => $o->getServiceOrder(),
                    'idv' => $o->getServiceOrder(),
                    'ids' => $o->getServiceOrder(),
                    'customer' => $o->getCustomer()->getBusinessName(),
                    'pq' => $o->getPriceQuotation()->getCode(),
                    'pqd' => $o->getPriceQuotationDetail()->getName(),
                    'departureLocation' => $o->getDepartureLocation(),
                    'arrivalLocation' => $o->getArrivalLocation(),
                    'departureDate' => $o->getDepartureDate()->format('d-m-Y'),
                    'arrivalDate' => $o->getArrivalDate()->format('d-m-Y'),
                    'time' => $o->getStartTime() . ' - ' . $o->getEndTime(),
                    'driver' => ($o->getDriver() != null ? $o->getDriver()->getUsername() : 'Nessuno'),
                    'vehicle' => ($o->getVehicle() != null ? $o->getVehicle()->getPlate() : 'Nessuno'),
                    'price' => $o->getPrice(),
                    'frequency' => $o->getServiceFrequency()->getServiceName(),
                    'service' => $o->getService()->getService(),
                    'passengers' => $o->getPassengers(),
                    'status' => $o->getStatus()
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