<?php

namespace AppBundle\Helper\DataImport;

use AppBundle\Entity\Address;
use AppBundle\Entity\Category;
use AppBundle\Entity\Provider;
use DateTime;
use Exception;

class ProviderImportHelper extends AbstractImportHelper
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
                $provider = new Provider();

                $category = $this->em->getRepository(Category::class)->find($c['Tipologgia']);

                $provider
                    ->setIdProvider($c['CodiceFornitori'])
                    ->setBusinessName($c['NomeSocietà'])
                    ->setFullAddress($this->prepareAddress($c))
                    ->setCategory($category)
                    ->setPhone($c['Telefono'])
                    ->setMobile($c['Cellulare'])
                    ->setFax($c['Fax'])
                    ->setEmail($c['HomePage'])
                    ->setVat($c['PI'])
                    ->setCf($c['CF_PI'])
                    ->setWebsite($c['HomePage'])
                    ->setRating($c['Giudizio'] == null ? 0 : (float)$c['Giudizio'])
                    ->setRegistrationDate(new DateTime());

                $this->em->persist($provider);

                $metadata = $this->em->getClassMetaData(get_class($provider));
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