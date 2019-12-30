<?php

namespace AppBundle\Helper\DataImport;

use AppBundle\Entity\Loan\Loan;
use AppBundle\Entity\Loan\LoanInstalment;
use AppBundle\Entity\Payment\BankAccount;
use AppBundle\Util\NumberUtils;

class LoanInstalmentImportHelper extends AbstractImportHelper
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
                $l = $this->em->getRepository(Loan::class)->find($c['IDMutuo']);
                $i = new LoanInstalment();
                $b = $this->em->getRepository(BankAccount::class)->find($c['Banca1'] == null ? 1 : $c['Banca1']);

                $paymentType = "";

                if($c['ModPagamento1'] != null) {
                    $p = strtolower($c['ModPagamento1']);

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

                if($l == null) continue;

                $i
                    ->setLoan($l)
                    ->setInstalmentNumber($c['NRata'])
                    ->setPaymentDate($c['DataAcconto1'] == null ? new \DateTime() : \DateTime::createFromFormat('d/m/Y', $c['DataAcconto1']))
                    ->setAmount((float) NumberUtils::convertStringToFloat($c['Acconto1']))
                    ->setCapital((float) NumberUtils::convertStringToFloat($c['QuotaCapitale']))
                    ->setInterests((float) NumberUtils::convertStringToFloat($c['QuotaInteressi']))
                    ->setInterestRate((float) NumberUtils::convertStringToFloat($l->getInterestRate()))
                    ->setPaymentType($paymentType)
                    ->setBankAccount($b);

                $this->em->persist($i);
                $this->persist();
                $this->success[] = $c['NRata'];
            } catch (\Exception $e) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration(),
                    $this->em->close()
                );
                $this->errors[] = $c['NRata'];
                continue;
            }
        }
        $this->persist();
    }
}