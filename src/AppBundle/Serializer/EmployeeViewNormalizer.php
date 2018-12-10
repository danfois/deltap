<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\Employee\Employee;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EmployeeViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Employee) {
                $r[] = [
                    'id'            => $o->getEmployeeId(),
                    'idv'           => $o->getEmployeeId(),
                    'name'          => $o->getSurname() . ' ' . $o->getName(),
                    'code'          => $o->getEmployeeCode(),
                    'type'          => $o->getEmploymentType(),
                    'payGrade'      => $o->getPayGrade(),
                    'email'         => $o->getEmail(),
                    'phone'         => $o->getPhone(),
                    'mobile'        => $o->getMobile(),
                    'fired'         => $o->getIsFired()
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