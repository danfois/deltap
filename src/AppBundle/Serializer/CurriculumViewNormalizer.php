<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Employee\Curriculum;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CurriculumViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Curriculum) {

                $rChild = [
                    'id'        => $o->getCurriculumId(),
                    'ids'       => $o->getCurriculumId(),
                    'idv'       => $o->getCurriculumId(),
                    'qualification'    => $o->getQualification(),
                    'languages' => $o->getLanguages(),
                    'employee'      => $o->getEmployee()->getName() . ' ' . $o->getEmployee()->getSurname()
                ];

                $r[] = $rChild;
            }
        }

        return $r;
    }

    public function supportsNormalization($data, $format = null)
    {
        return true;
    }
}