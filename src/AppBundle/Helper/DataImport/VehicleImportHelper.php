<?php

namespace AppBundle\Helper\DataImport;

use AppBundle\Entity\Vehicle\Vehicle;
use Exception;

class VehicleImportHelper extends AbstractImportHelper
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
                $vehicle = new Vehicle();

                $vehicle
                    ->setVehicleId($c['CodiceAutobus'])
                    ->setPlate($c['Targa'])
                    ->setExPlate($c['ExTarga'])
                    ->setCarRegistrationDate($c['DataImmatricolazione'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataImmatricolazione']))
                    ->setCarRegistrationNumber($c['NImmatricolazione'])
                    ->setRegistrationCardDate($c['DataImmaCarta'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataImmaCarta']))
                    ->setBrand($c['Marca'])
                    ->setModel($c['Modello'])
                    ->setSeats($c['PostiS'])
                    ->setStands($c['PostiI'])
                    ->setWidth((float)$c['Larghezza'])
                    ->setLength((float)$c['Lunghezza'])
                    ->setFinancing($c['Finanziamento'])
                    ->setPurchaseDate($c['DataAcquisto'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataAcquisto']))
                    ->setSaleDate($c['DataVendita'] == null ? null : \DateTime::createFromFormat('d/m/Y', $c['DataVendita']))
                    ->setUseTypology($c['Uso'])
                    ->setUseDestination($c['DestinazioneUso'])
                    ->setBodyWork($c['Carrozzeria'])
                    ->setFrame($c['Telaio'])
                    ->setOwner($c['Intestatario'])
                    ->setTransmission($c['TipoCambio'])
                    ->setTires($c['Pneumatici'])
                    ->setAlternateTires($c['PneumaticiAlternativa'])
                    ->setRegionalAuthorization($c['AutRegionale'])
                    ->setAreation($c['Aereazione'])
                    ->setPassengersSeated((int)$c['PortataPaxS'])
                    ->setPassengersStanding((int)$c['PortataPaxI'])
                    ->setEmergencyExits((int)$c['UsciteEmergenza'])
                    ->setEngineNumber($c['NMotore'])
                    ->setOmologationNumber($c['NOmologazione'])
                    ->setMaximumLoadMass($c['MassaMaxCarico'])
                    ->setCategory($c['Categoria'])
                    ->setAxesNumber((int)$c['NAssi'])
                    ->setEngineCapacity($c['CilindrataMC'])
                    ->setPowerKw((int)$c['PotenzaKw'])
                    ->setFuel($c['Comb'])
                    ->setNotes($c['Note']);


                $this->em->persist($vehicle);

                $metadata = $this->em->getClassMetaData(get_class($vehicle));
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

                $this->persist();
                $this->success[] = $c['Targa'];

            } catch (Exception $e) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration(),
                    $this->em->close()
                );
                $this->errors[] = $c['Targa'];
                continue;
            }
        }
    }
}