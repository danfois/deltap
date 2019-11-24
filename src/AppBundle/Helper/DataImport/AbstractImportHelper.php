<?php

namespace AppBundle\Helper\DataImport;
use Doctrine\Common\Persistence\ObjectManager;
use League\Csv\Reader;

abstract class AbstractImportHelper
{
    protected $file;
    protected $reader;
    protected $em;
    protected $errors = array();
    protected $success = array();

    public function __construct($file, ObjectManager $em) {
        $this->file = $file;
        $this->reader = Reader::createFromFileObject($file);
        $this->em = $em;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    abstract public function import();

    protected function persist()
    {
        $this->em->flush();
        $this->em->clear();
    }
}