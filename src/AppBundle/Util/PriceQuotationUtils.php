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

        //this method is taken by repository class and returns instance of PriceQuotation. So the index is required to work
        //with methods that require a string
        $highestId = $em->getRepository(PriceQuotation::class)->findHighestId()['priceQuotationId'];

        if($highestId == null) {
            $fullCode = $firstPart . '1';
        } else {
            $fullCode = $firstPart . ((int)substr($highestId, strpos($highestId, "_")) + 1);
        }

        return $fullCode;
    }

    public static function generatePriceQuotationDetailCode(EntityManager $em)
    {
        $firstPart = date('Y') . 'IT-';

        //this method is taken by repository class and returns instance of PriceQuotation. So the index is required to work
        //with methods that require a string
        $highestId = $em->getRepository(PriceQuotationDetail::class)->findHighestId()['priceQuotationDetailId'];

        if($highestId == null) {
            $fullCode = $firstPart . '1';
        } else {
            $fullCode = $firstPart . ((int)substr($highestId, strpos($highestId, "_")) + 1);
        }

        return $fullCode;
    }
}