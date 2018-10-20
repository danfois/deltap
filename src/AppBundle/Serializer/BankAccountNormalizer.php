<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Payment\BankAccount;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BankAccountNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof BankAccount) {

                $r[] = [
                    'id' => $o->getBankAccountId(),
                    'idv' => $o->getBankAccountId(),
                    'ids' => $o->getBankAccountId(),
                    'bankName' => $o->getBankName(),
                    'owner' => $o->getOwner(),
                    'iban' => $o->getCountry() . ' '
                            . $o->getCheck() . ' '
                            . $o->getCin() . ' '
                            . $o->getAbi() . ' '
                            . $o->getCab() . ' '
                            . $o->getAccountNumber()
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