<?php

namespace AppBundle\Util;

use AppBundle\Entity\Invoice\IssuedInvoice;
use AppBundle\Entity\Invoice\ReceivedInvoice;
use AppBundle\Entity\Payment\Payment;
use AppBundle\Entity\ServiceOrder\ServiceOrder;
use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Entity\Vehicle\CarTax;
use AppBundle\Entity\Vehicle\Insurance;

class ClassResolver
{
    public static function resolveClass(string $class)
    {
        $availableClasses = array(
            'issuedInvoice' => IssuedInvoice::class,
            'receivedInvoice' => ReceivedInvoice::class,
            'payment' => Payment::class,
            'serviceOrder' => ServiceOrder::class,
            'insurance' => Insurance::class,
            'cartax' => CarTax::class,
            'carreview' => CarReview::class
        );

        if($availableClasses[$class] === null) return false;

        return $availableClasses[$class];
    }
}