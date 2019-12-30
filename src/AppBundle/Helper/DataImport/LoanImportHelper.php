<?php

namespace AppBundle\Helper\DataImport;

use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Provider;
use AppBundle\Util\NumberUtils;
use Exception;

class LoanImportHelper extends AbstractImportHelper
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
                $bank = null;
                if($c['Banca'] != null) {
                    $bank = $this->em->getRepository(Provider::class)->find($c['Banca']);
                    if($bank == null) {
                        $bank = $this->em->getRepository(Provider::class)->find(1);
                    }
                } else {
                    $bank = $this->em->getRepository(Provider::class)->find(1);
                }

                $instalmentType = "";
                $paymentType = "";
                if($c['Rateizzazione'] != null) {
                    switch($c['Rateizzazione']) {
                        case 'MENSILE':
                            $instalmentType = 'MONTHLY';
                            break;
                        case 'TRIMESTRALE':
                            $instalmentType = 'QUARTERLY';
                            break;
                        case 'SEMESTRALE':
                            $instalmentType = 'HALFYEARLY';
                            break;
                    }
                } else {
                    $instalmentType = 'MONTHLY';
                }

                if($c['ModPagamento'] != null) {
                    $p = strtolower($c['ModPagamento']);

                    switch($p) {
                        case 'bonifico':
                            $paymentType = 'TRANSFER';
                            break;
                        case 'rimessa diretta':
                            $paymentType = 'CASH';
                            break;
                        case 'rid':
                            $paymentType = 'RID';
                            break;
                    }
                } else {
                    $paymentType = 'CASH';
                }

                $loan = new Loan();
                $loan
                    ->setLoanId($c['IDMutuo'])
                    ->setProvider($bank)
                    ->setLoanNumber($c['NMutuo'])
                    ->setLoanDate($c['DataMutuo'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataMutuo']))
                    ->setFinancedAmount((float) NumberUtils::convertStringToFloat($c['ImportoFinanziamento']))
                    ->setInterestRate((float) $c['Tasso'] == null ? 0 : NumberUtils::convertStringToFloat($c['Tasso']))
                    ->setInterestType('FIXED')
                    ->setInstalmentType($instalmentType)
                    ->setInstalmentNumber($c['NRate'])
                    ->setFirstInstalmentDate($c['DataPrimaRata'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataPrimaRata']))
                    ->setLastInstalmentDate($c['DataUltimaRata'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataUltimaRata']))
                    ->setPaymentType($paymentType)
                    ->setAnticipation((float) NumberUtils::convertStringToFloat($c['Anticipo']))
                    ->setRedemption((float) NumberUtils::convertStringToFloat($c['Riscatto']))
                    ->setMortgages($c['Ipoteche'])
                    ->setNotes($c['Note'])
                    ->setPreAmortization((float) NumberUtils::convertStringToFloat($c['Preammortamento']))
                    ->setOperationCost((float) NumberUtils::convertStringToFloat($c['SpesePratica']))
                    ->setExpectedInterests((float) NumberUtils::convertStringToFloat($c['Interessi']))
                    ->setLoanCost((float) NumberUtils::convertStringToFloat($c['SpesePratica']))
                    ->setInstalmentAmount((float) NumberUtils::convertStringToFloat($c['ImportoRata']));

                $this->em->persist($loan);

                $metadata = $this->em->getClassMetaData(get_class($loan));
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

                $this->persist();
                $this->success[] = $c['NMutuo'];
            } catch (Exception $e) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration(),
                    $this->em->close()
                );
                $this->errors[] = $c['NMutuo'];
                continue;
            }
        }
        $this->persist();
    }
}