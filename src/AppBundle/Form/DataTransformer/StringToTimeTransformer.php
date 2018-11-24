<?php

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class StringToTimeTransformer implements DataTransformerInterface
{
    /**
     * Converte da stringa a valore del form
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        return $value->format('H:i');
    }

    /**
     * Converte da valore del form a stringa
     */
    public function reverseTransform($value)
    {
        if($value == null) return null;
        return \DateTime::createFromFormat('H:i', $value);
    }
}