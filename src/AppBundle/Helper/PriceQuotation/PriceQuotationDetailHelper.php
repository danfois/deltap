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
        $this->iterateStages();
        $this->executed = 1;
    }

    public function getErrors()
    {
        if($this->executed === 0) throw new \Exception('Class not executed - PriceQuotationDetailHelper::getErrors()');
        return $this->errors;
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

            $SH = null;
        }
    }
}