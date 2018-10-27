<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\PurchaseOrder\PurchaseOrder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PurchaseOrderNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof PurchaseOrder) {

                $r[] = [
                    'id' => $o->getPurchaseOrderId(),
                    'ids' => $o->getPurchaseOrderId(),
                    'idv' => $o->getPurchaseOrderId(),
                    'provider' => $o->getProvider()->getBusinessName(),
                    'referencePerson' => $o->getReferencePerson(),
                    'employee' => $o->getEmployee()->getName() . ' ' . $o->getEmployee()->getSurname(),
                    'orderDate' => $o->getOrderDate()->format('d-m-Y'),
                    'expirationDate' => $o->getExpirationDate()->format('d-m-Y'),
                    'deliveryDate' => $o->getDeliveryDate()->format('d-m-Y'),
                    'referent' => $o->getReferent()->getName() . ' ' . $o->getReferent()->getSurname(),
                    'orderType' => $o->getOrderType()
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