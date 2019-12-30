<?php

namespace AppBundle\Util;

class NumberUtils
{
    public static function convertStringToFloat($s) {
        $a = str_replace(",", ".", str_replace(".", "", $s));
        return $a;
    }
}