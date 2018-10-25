<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\PurchaseOrder\PurchaseOrderDetail;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PurchaseOrderDetailNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof PurchaseOrderDetail) {

                $r[] = [
                    'id' => $o->getPurchaseOrderDetailId(),
                    'ids' => $o->getPurchaseOrderDetailId(),
                    'idv' => $o->getPurchaseOrderDetailId(),
                    'quantity' => $o->getQuantity(),
                    'description' => $o->getDescription(),
                    'vehicle' => $o->getVehicle()->getPlate()
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