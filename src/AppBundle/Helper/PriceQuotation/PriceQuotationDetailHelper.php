<?php

namespace AppBundle\Helper\PriceQuotation;

use AppBundle\Entity\PriceQuotation\PriceQuotationDetail;
use Doctrine\ORM\EntityManager;

class PriceQuotationDetailHelper
{
    protected $priceQuotationDetail;
    protected $em;
    protected $errors;
    protected $executed = 0;
    protected $isEdited;

    public function __construct(PriceQuotationDetail $priceQuotationDetail, EntityManager $em, bool $isEdited = false)
    {
        $this->priceQuotationDetail = $priceQuotationDetail;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        if($this->isEdited === false) $this->setBaseOrderEmitted();
        $this->checkCodeUnique();
        $this->iterateStages();
        $this->prepareAndUploadAttachment();
        $this->executed = 1;
    }

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not executed - PriceQuotationDetailHelper::getErrors()');
        return $this->errors;
    }

    protected function checkCodeUnique()
    {
        $pqd = $this->em->getRepository(PriceQuotationDetail::class)->findOneBy(array('name' => $this->priceQuotationDetail->getName()));
        if($pqd == null) return true;
        if($pqd->getPriceQuotationDetailId() == $this->priceQuotationDetail->getPriceQuotationDetailId()) return true;
        $this->errors .= 'Esiste già un itinerario con questo codice<br>';
        return false;
    }

    protected function prepareAndUploadAttachment()
    {
        $f = $this->priceQuotationDetail->getAttachment();
        if($f != null) {
            if($f->getFile() != null) {
                $this->priceQuotationDetail->setAttachment($f);
                $f->setName($this->priceQuotationDetail->getName() . '_allegato_' . substr(md5(rand(1, 100)), 0, 8) . '.' . $f->getFile()->guessExtension());
                $f->upload();
            } else {
                $this->priceQuotationDetail->setAttachment(null);
            }
        }
    }

    protected function setBaseOrderEmitted()
    {
        $this->priceQuotationDetail->setEmittedOrders(0);
    }

    protected function iterateStages()
    {
        foreach($this->priceQuotationDetail->getStages() as $s) {
            $SH = new StageHelper($s, $this->em, $this->isEdited);
            $SH->execute();

            $errors = $SH->getErrors();

            if($errors != null) {
                $this->errors .= $errors;
            }

            $s->setPriceQuotationDetail($this->priceQuotationDetail);

            $SH = null;
        }
    }
}