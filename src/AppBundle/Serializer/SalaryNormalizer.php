<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Salary\Salary;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SalaryNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Salary) {

                $balance = 0;

                foreach($o->getSalaryDetails() as $d) {
                    $balance += $d->getPayment()->getAmount();
                }

                $r[] = [
                    'id' => $o->getSalaryId(),
                    'ids' => $o->getSalaryId(),
                    'idv' => $o->getSalaryId(),
                    'date' => str_pad($o->getMonth(), 2, "0", STR_PAD_LEFT) .'/'.$o->getYear(),
                    'employee' => $o->getEmployee()->getSurname() . ' ' . $o->getEmployee()->getName(),
                    'amount' => $o->getAmount(),
                    'causal' => $o->getCausal(),
                    'balance' => $balance,
                    'remaining' => $o->getAmount() - $balance
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