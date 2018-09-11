<?php

namespace AppBundle\Util;

use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use Doctrine\ORM\EntityManager;

class PriceQuotationUtils
{
    public static function generatePriceQuotationCode(EntityManager $em)
    {
        $firstPart = date('Y') . '-';

        $highestId = $em->getRepository(PriceQuotation::class)->findHighestId();

        if($highestId == null) {
            $fullCode = $firstPart . '1';
        } else {
            $fullCode = $firstPart . ($highestId + 1);
        }

        return $fullCode;
    }

    public static function generatePriceQuotationDetailCode(EntityManager $em)
    {
        $firstPart = date('Y') . '-';
        $highestId = $em->getRepository(PriceQuotationDetail::class)->findHighestId();

        if($highestId == null) {
            $fullCode = $firstPart . '1';
        } else {
            $fullCode = $firstPart . ($highestId + 1);
        }

        return $fullCode;
    }
}