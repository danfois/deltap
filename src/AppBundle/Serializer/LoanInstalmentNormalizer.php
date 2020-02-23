<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Loan\LoanInstalment;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LoanInstalmentNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof LoanInstalment) {

                $r[] = [
                    'id' => $o->getLoanInstalmentId(),
                    'ids' => $o->getLoanInstalmentId(),
                    'idv' => $o->getLoanInstalmentId(),
                    'paymentDate' => $o->getPaymentDate()->format('d-m-Y'),
                    'amount' => $o->getAmount(),
                    'interestRate' => $o->getInterestRate(),
                    'paymentType' => $o->getPaymentType(),
                    'bankAccount' => $o->getBankAccount()->getBankName() . ' - ' . $o->getBankAccount()->getAccountNumber(),
                    'paid' => $o->getPayment() != null ? 'Si' : 'No'
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