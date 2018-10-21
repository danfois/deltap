<?php

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class StringToDateTransformer implements DataTransformerInterface
{
    /**
     * Converte da stringa a valore del form
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        return $value->format('d/m/Y');
    }

    /**
     * Converte da valore del form a stringa
     */
    public function reverseTransform($value)
    {
        if($value == null) return null;
        return \DateTime::createFromFormat('d/m/Y', $value);
    }
}