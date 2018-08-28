<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Employee\DriverQualificationLetter;
use AppBundle\Entity\Employee\DrivingDocument;
use AppBundle\Entity\Employee\DrivingLetter;
use AppBundle\Entity\Employee\DrivingLicense;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DrivingDocumentViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof DrivingDocument) {

                $status = '1';
                if(new \DateTime() > $o->getExpiration()) $status = '2';
                if(new \DateTime('+1 month') > $o->getExpiration()) $status = '3';

                $id = 0;

                if($o instanceof DrivingLicense) $id = $o->getLicenseId();
                if($o instanceof DrivingLetter) $id = $o->getLetterId();
                if($o instanceof DriverQualificationLetter) $id = $o->getQualificationId();

                $rChild = [
                    'id'        => $id,
                    'ids'       => $id,
                    'idv'       => $id,
                    'number'    => $o->getNumber(),
                    'expiration' => $o->getExpiration()->format('d/m/Y'),
                    'releaseDate'   => $o->getReleaseDate()->format('d/m/Y'),
                    'releasedBy'     => $o->getReleasedBy(),
                    'employee'      => $o->getEmployee()->getName() . ' ' . $o->getEmployee()->getSurname(),
                    'status'    => $status
                ];

                if($o instanceof DrivingLicense) $rChild['type'] = $o->getType();

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