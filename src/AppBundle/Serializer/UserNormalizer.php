<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof User) {

                $r[] = [
                    'id' => $o->getIdUser(),
                    'ids' => $o->getIdUser(),
                    'idv' => $o->getIdUser(),
                    'username' => $o->getUsername(),
                    'status' => $o->getStatus(),
                    'employee' => ($o->getEmployee() != null ? $o->getEmployee()->getName() . ' ' . $o->getEmployee()->getSurname() : ''),
                    'roles' => implode(', ', $o->getRoles())
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