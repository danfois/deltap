<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Customer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomerNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Customer) {

                $r[] = [
                    'id' => $o->getIdCustomer(),
                    'ids' => $o->getIdCustomer(),
                    'idv' => $o->getIdCustomer(),
                    'businessName' => $o->getBusinessName(),
                    'address' => $o->getFullAddress()->getAddress() . ', ' . $o->getFullAddress()->getCity() . ', ' . $o->getFullAddress()->getCap(),
                    'email' => $o->getEmail(),
                    'phone' => $o->getPhone() . ' / ' . $o->getMobile(),
                    'category' => ($o->getCategory() != null ? $o->getCategory()->getCategoryName() : '')
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