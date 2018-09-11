<?php

namespace AppBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateTags extends Constraint
{
    public $message = 'The field "{{string}}" must contains dates in format dd/mm/yyyy separated by commas';
}