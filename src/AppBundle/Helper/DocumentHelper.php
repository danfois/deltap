<?php

namespace AppBundle\Helper;

use AppBundle\Entity\Document;
use AppBundle\Entity\Employee\Employee;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;

class DocumentHelper
{
    protected $files;
    protected $em;
    protected $employee;
    protected $document_array = array();
    protected $documentType;
    protected $errors;
    protected $executed = 0;

    public function __construct(array $files, EntityManager $em, Employee $employee, string $documentType = 'generico')
    {
        $this->files = $files;
        $this->em = $em;
        $this->employee = $employee;
        $this->documentType = $documentType;
    }

    public function execute()
    {
        $this->createDocuments();
        $this->executed = 1;
    }

    protected function createDocuments()
    {
        try {
            $date = new \DateTime();
            $counter = 1;

            foreach ($this->files as $f) {
                $rn = rand(1, 100);
                $d = new Document();
                $d->setName($this->employee->getName() . '_' . $this->employee->getSurname() . '_' . $this->documentType . '_' . $date->format('d-m-Y') . '_' . substr(md5($rn), 0, 8) . '.' . $f->guessExtension());
                $d->setFile($f);

                $this->document_array[] = $d;
                $counter++;
            }
        } catch (\Exception $e) {
            $this->errors .= 'Errore durante la creazione dei documenti in "DocumentHelper::createDocuments"<br>';
        }
    }

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not executed');
        return $this->errors;
    }

    public function getDocumentArray()
    {
        return $this->document_array;
    }
}