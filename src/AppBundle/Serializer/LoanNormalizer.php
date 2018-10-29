<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Loan\Loan;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LoanNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Loan) {

                $r[] = [
                    'id' => $o->getLoanId(),
                    'ids' => $o->getLoanId(),
                    'idv' => $o->getLoanId(),
                    'number' => $o->getLoanNumber(),
                    'provider' => $o->getProvider()->getBusinessName(),
                    'amount' => $o->getFinancedAmount(),
                    'interestRate' => $o->getInterestRate(),
                    'interestType' => $o->getInterestType(),
                    'instalmentType' => $o->getInstalmentType(),
                    'instalmentNumber' => $o->getInstalmentNumber()
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