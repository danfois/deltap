<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\DrivingDocument;
use Doctrine\ORM\EntityManager;

abstract class DrivingDocumentHelper
{
    protected $instance;
    protected $em;
    protected $errors;
    protected $executed = 0;
    protected $isEdited;

    public function __construct(DrivingDocument $instance, EntityManager $em, bool $isEdited = false)
    {
        $this->instance = $instance;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    abstract public function execute();

    abstract protected function checkSameDocument();

    protected function checkDateCoherence()
    {
        if($this->instance->getReleaseDate() > new \DateTime()) return true;
        $this->errors .= 'La data di rilascio è successiva alla data odierna<br>';
        return false;
    }

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not executed');
        return $this->errors;
    }
}