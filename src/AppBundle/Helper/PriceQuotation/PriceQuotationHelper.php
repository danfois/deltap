<?php

namespace AppBundle\Helper\PriceQuotation;

use AppBundle\Entity\PriceQuotation\PriceQuotation;
use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use AppBundle\Entity\User;
use AppBundle\Util\PriceQuotationUtils;
use Doctrine\ORM\EntityManager;

class PriceQuotationHelper
{
    private $priceQuotation;
    private $em;
    private $user;
    private $errors;
    private $executed;

    public function __construct(PriceQuotation $priceQuotation, EntityManager $em, User $user)
    {
        $this->priceQuotation = $priceQuotation;
        $this->em = $em;
        $this->user = $user;
    }

    public function execute()
    {
        $this->checkDetails();
        $this->setUser();
        $this->setStatus();
        $this->checkSamePriceQuotation();
        $this->executed = 1;
    }

    /**
     * This method iterate each PriceQuotationDetail.
     * Since details can already exists, it checks if it has already a PriceQuotation associated.
     * If it has then checks if the PriceQuotationId is the same of the current instance.
     * If it's not then the Detail gets cloned, as well as his stages, and gets associated to the new PriceQuotation and persisted.
     */
    private function checkDetails()
    {
        foreach ($this->priceQuotation->getPriceQuotationDetails() as $p) {
            if ($p instanceof PriceQuotationDetail) {
                if ($p->getPriceQuotation() == null) continue;
                if ($p->getPriceQuotation() != null && $p->getPriceQuotation()->getPriceQuotationId() == $this->priceQuotation->getPriceQuotationId()) continue;
                $newP = clone $p;
                $newP->setPriceQuotation($this->priceQuotation);
                $newP->setName(PriceQuotationUtils::generatePriceQuotationDetailCode($this->em));
                $this->priceQuotation->removePriceQuotationDetailForCloning($p);
                $this->priceQuotation->addPriceQuotationDetail($newP);
                foreach($p->getStages() as $s) {
                    $newS = clone $s;
                    $newP->addStage($newS);
                    $newS->setPriceQuotationDetail($newP);
                    $this->em->persist($newS);
                }
            }
        }
    }

    private function checkSamePriceQuotation()
    {
        $pq = $this->em->getRepository(PriceQuotation::class)->findOneBy(array('code' => $this->priceQuotation->getCode()));
        if ($pq == null) return true;
        if ($pq->getPriceQuotationId() == $this->priceQuotation->getPriceQuotationId()) return true;
        $this->errors .= 'Esiste già un preventivo multiplo con questo codice<br>';
        return false;
    }

    private function setUser()
    {
        if ($this->priceQuotation->setAuthor($this->user)) return true;
        $this->errors .= 'Impossibile impostare l\'autore del preventivo<br>';
        return false;
    }

    private function setStatus()
    {
        if ($this->priceQuotation->setStatus(1)) return true;
        $this->errors .= 'Impossibile impostare lo status del preventivo<br>';
        return false;
    }


    public function getErrors()
    {
        if ($this->executed === 0) throw new \Exception('Class Not Executed');
        return $this->errors;
    }
}