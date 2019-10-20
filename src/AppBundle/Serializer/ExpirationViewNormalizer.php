<?php

namespace AppBundle\Serializer;
use AppBundle\Entity\Expiration;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExpirationViewNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        $r = array();

        foreach($object as $o) {
            if($o instanceof Expiration) {

                $r[] = [
                    'id' => $o->getExpirationId(),
                    'ids' => $o->getExpirationId(),
                    'idv' => $o->getExpirationId(),
                    'title' => $o->getTitle(),
                    'description' => $o->getDescription(),
                    'expirationDate' => $o->getExpirationDate()->format('d-m-Y'),
                    'createdAt' => $o->getCreatedAt()->format('d-m-Y'),
                    'createdBy' => $o->getUser()->getEmployee()->getName() . " " . $o->getUser()->getEmployee()->getSurname(),
                    'issuedInvoiceNumber' => $o->getIssuedInvoice() == null ? "" : $o->getIssuedInvoice()->getInvoiceNumber(),
                    'receivedInvoiceNumber' => $o->getReceivedInvoice() == null ? "" : $o->getReceivedInvoice()->getInvoiceNumber(),
                    'isResolved' => $o->getIsResolved() == true ? "Si" : "No",
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