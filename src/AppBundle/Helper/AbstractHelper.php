<?php

namespace AppBundle\Helper;

abstract class AbstractHelper
{
    protected $em;
    protected $isEdited;
    protected $instance;
    protected $executed = 0;
    protected $errors;

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not executed');
        return $this->errors;
    }

    public abstract function execute();
}