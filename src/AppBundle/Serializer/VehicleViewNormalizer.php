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
                    'purchaseDate'  => ($o->getPurchaseDate() != null ? $o->getPurchaseDate()->format('d/m/Y') : ''),
                    'insuranceEnd'  => ($o->getCurrentInsurance() != null ? $o->getCurrentInsurance()->getEndDate()->format('d/m/Y') : ''),
                    'cartaxEnd'     => ($o->getCurrentCarTax() != null ? $o->getCurrentCarTax()->getEndDate()->format('d/m/Y') : ''),
                    'carreviewEnd'  => ($o->getCurrentCarReview() != null ? $o->getCurrentCarReview()->getEndDate()->format('d/m/Y') : ''),
                    'insuranceId'   => ($o->getCurrentInsurance() != null ? $o->getCurrentInsurance()->getInsuranceId() : '0'),
                    'carTaxId'      => ($o->getCurrentCarTax() != null ? $o->getCurrentCarTax()->getCarTaxId() : '0'),
                    'carReviewId'   => ($o->getCurrentCarReview() != null ? $o->getCurrentCarReview()->getCarReviewId() : '0'),
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