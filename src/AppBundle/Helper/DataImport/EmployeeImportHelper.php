<?php

namespace AppBundle\Helper\DataImport;

use AppBundle\Entity\Address;
use AppBundle\Entity\Employee\Employee;
use Exception;

class EmployeeImportHelper extends AbstractImportHelper
{
    public function import()
    {
        $this->startImportProcess();
    }

    private function startImportProcess()
    {
        $csv = $this->reader->setHeaderOffset(0);
        $csv->setDelimiter(';');

        foreach ($csv as $c) {
            try {
                $employee = new Employee();
                $employee
                    ->setEmployeeId($c['CodiceAutista'])
                    ->setName(explode(" ", $c['NomeSocietà'])[1])
                    ->setSurname(explode(" ", $c['NomeSocietà'])[0])
                    ->setBirthDate($c['DataNascita'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataNascita']))
                    ->setBirthPlace($c['LuogoNascita'])
                    ->setFullAddress($this->prepareAddress($c))
                    ->setCf($c['CF_PI'])
                    ->setPhone($c['Telefono'])
                    ->setFax($c['Fax'])
                    ->setMobile($c['Cellulare'])
                    ->setEmail($c['HomePage'])
                    ->setEmployeeCode($c['CodiceAutista'])
                    ->setEmploymentType(strpos($c['Dipendente'], 'FISSO') !== false ? 1 : 2)
                    ->setAdmission($c['Assunzione'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['Assunzione']))
                    ->setDuties($c['Mansioni'])
                    ->setPayGrade($c['Inquadramento'])
                    ->setIsFired(0)
                    ->setTerminationDate($c['Dimissioni'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['Dimissioni']));

                $this->em->persist($employee);

                $metadata = $this->em->getClassMetaData(get_class($employee));
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

                $this->persist();
                $this->success[] = $c['NomeSocietà'];

            } catch (Exception $e) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration(),
                    $this->em->close()
                );
                $this->errors[] = $c['NomeSocietà'];
                continue;
            }
        }
    }

    private function prepareAddress($csvItem) : Address
    {
        try {
            $address = new Address();
            $address
                ->setAddress($csvItem['Indirizzo'])
                ->setCity($csvItem['Città'])
                ->setCap($csvItem['CAP'])
                ->setCountry("Italia")
                ->setZone($csvItem['Zona']);

            return $address;
        } catch (Exception $e) {
            return null;
        }
    }
}