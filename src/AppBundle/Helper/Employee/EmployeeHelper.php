<?php

namespace AppBundle\Helper\Employee;

use AppBundle\Entity\Employee\Employee;
use Doctrine\ORM\EntityManager;

class EmployeeHelper
{
    protected $instance;
    protected $em;
    protected $errors;
    protected $isEdited;
    protected $executed = 0;

    public function __construct(Employee $instance, EntityManager $em, bool $isEdited = false)
    {
        $this->instance = $instance;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->setAdmissionDate();
        $this->setBirthDate();

        if($this->isEdited === false) {
            $this->setIsFired();
        }

        $this->executed = 1;
    }

    protected function setAdmissionDate()
    {
        if($this->instance->setAdmission(\DateTime::createFromFormat('d/m/Y', $this->instance->getAdmission()))) return true;
        $this->errors .= 'Impossibile impostare la data di Assunzione; <br>';
        return false;
    }

    protected function setBirthDate()
    {
        if($this->instance->setBirthDate(\DateTime::createFromFormat('d/m/Y', $this->instance->getBirthDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di nascita; <br>';
        return false;
    }

    protected function setIsFired()
    {
        if($this->instance->setIsFired(0)) return true;
        $this->errors .= 'Impossibile stabilire lo stato di assunzione del dipendente<br>';
        return false;
    }

    public function getErrors() {
        if($this->executed == 0) {
            throw new \Exception('La classe non è ancora stata eseguita');
        }
        return $this->errors;
    }
}