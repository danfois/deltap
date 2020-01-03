<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Provider;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProviderNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Provider) {

                $r[] = [
                    'id' => $o->getIdProvider(),
                    'ids' => $o->getIdProvider(),
                    'idv' => $o->getIdProvider(),
                    'businessName' => $o->getBusinessName(),
                    'address' => $o->getFullAddress()->getAddress() . ', ' . $o->getFullAddress()->getCity() . ', ' . $o->getFullAddress()->getCap(),
                    'email' => $o->getEmail(),
                    'phone' => $o->getPhone() . ' / ' . $o->getMobile(),
                    'category' =>  ($o->getCategory() != null ? $o->getCategory()->getCategoryName() : ''),
                    'critical' => $o->getCritical() ? 'Si' : 'No'
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