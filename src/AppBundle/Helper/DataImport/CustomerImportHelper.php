<?php

namespace AppBundle\Helper\DataImport;
use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use DateTime;
use Exception;

class CustomerImportHelper extends AbstractImportHelper
{
    public function import()
    {
        $this->startImportProcess();
    }

    protected function startImportProcess()
    {
        $csv = $this->reader->setHeaderOffset(0);
        $csv->setDelimiter(';');

        foreach($csv as $c) {
            try {
                $customer = new Customer();
                $customer
                    ->setBusinessName($c['NomeSocietà'])
                    ->setFullAddress($this->prepareAddress($c))
                    ->setPhone($c['Telefono'])
                    ->setMobile($c['Cellulare'])
                    ->setFax($c['Fax'])
                    ->setEmail($c['IndirizzoMail'])
                    ->setVat($c['PI'])
                    ->setCf($c['CF_PI'])
                    ->setWebsite($c['HomePage'])
                    ->setCuu($c['CUU'])
                    ->setRegistrationDate(new DateTime());

                $this->em->persist($customer);
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

        $this->persist();
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

    protected function persist()
    {
        $this->em->flush();
        $this->em->clear();
    }
}