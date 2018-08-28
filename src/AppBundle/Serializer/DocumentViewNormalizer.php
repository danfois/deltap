<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Document;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DocumentViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Document) {

                $type = '';
                if($o->getCurriculum() != null) $type = 1;
                if($o->getDrivingLicense() != null) $type = 2;
                if($o->getDrivingLetter() != null) $type = 3;
                if($o->getDriverQualificationLetter() != null) $type = 4;

                $r[] = [
                    'id'        => $o->getDocumentId(),
                    'idv'       => $o->getDocumentId(),
                    'name'      => $o->getName(),
                    'path'      => $o->getWebPath() . $o->getPath(),
                    'type'      => $type
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