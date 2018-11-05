<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Employee\EmployeeUnavailability;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EmployeeUnavailabilityNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof EmployeeUnavailability) {

                $status = '1';
                if(new \DateTime() > $o->getEndDate()) $status = '2';
                else if(new \DateTime('+1 month') > $o->getEndDate()) $status = '3';

                $r[] = [
                    'id'        => $o->getUnavailabilityId(),
                    'idv'       => $o->getUnavailabilityId(),
                    'startDate' => $o->getStartDate()->format('d/m/Y'),
                    'endDate'   => $o->getEndDate()->format('d/m/Y'),
                    'issue'     => $o->getIssue(),
                    'employee'   => $o->getEmployee()->getName() . ' ' . $o->getEmployee()->getSurname(),
                    'status'    => $status
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