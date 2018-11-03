<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Salary\SalaryDetail;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SalaryDetailNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof SalaryDetail) {
                $payment = $o->getPayment();

                $r[] = [
                    'id' => $o->getSalaryDetailId(),
                    'ids' => $o->getSalaryDetailId(),
                    'idv' => $o->getSalaryDetailId(),
                    'amount' => $payment->getAmount(),
                    'paymentDate' => $payment->getPaymentDate()->format('d-m-Y'),
                    'type' => $payment->getPaymentType(),
                    'bankAccount' => $payment->getBankAccount()->getBankName() . ' - ' . $payment->getBankAccount()->getAccountNumber(),
                    'direction' => $payment->getDirection(),
                    'paymentId' => $payment->getPaymentId()
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