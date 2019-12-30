<?php

namespace AppBundle\Helper\DataImport;

use AppBundle\Entity\Payment\BankAccount;
use Exception;

class BankAccountImportHelper extends AbstractImportHelper
{
    public function import()
    {
        $this->startImportProcess();
    }

    private function startImportProcess()
    {
        $csv = $this->reader->setHeaderOffset(0);
        $csv->setDelimiter(';');

        foreach($csv as $c) {
            try {
                $b = new BankAccount();

                $b
                    ->setBankName($c['BancaAppoggio'])
                    ->setOwner($c['IntestazioneCC'])
                    ->setCountry($c['Naz'])
                    ->setCheck($c['Check'] == null ? "00" : $c['Check'])
                    ->setCin($c['CIN'] == null ? "0" : $c['CIN'])
                    ->setAbi($c['Abi'] == null ? "0000" : $c['Abi'])
                    ->setCab($c['Cab'] == null ? "00000" : $c['Cab'])
                    ->setAccountNumber($c['CC'] == null ? "00000" : $c['CC']);

                $this->em->persist($b);
                $this->persist();
                $this->success[] =$c['IDBanca'] . " " . $c['BancaAppoggio'];
            } catch (Exception $e) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration(),
                    $this->em->close()
                );
                $this->errors[] = $c['IDBanca'] . " " . $c['BancaAppoggio'];
                continue;
            }
        }

        $this->persist();
    }
}