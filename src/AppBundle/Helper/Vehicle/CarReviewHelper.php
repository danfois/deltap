<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\CarReview;
use Doctrine\ORM\EntityManager;

class CarReviewHelper extends AbstractPeriodicCostHelper
{
    protected $em;
    protected $errors;
    protected $isEdited;
    protected $executed = 0;

    public function __construct(CarReview $carReview, EntityManager $em, bool $isEdited = false)
    {
        parent::__construct($carReview, $em, $isEdited);
    }

    public function execute()
    {
        $this->setStartDate();
        $this->setEndDate();
        $this->checkDateCoherence();
        if($this->isEdited === false) $this->checkSameCarReview();
        $this->executed = 1;
    }

    private function checkSameCarReview()
    {
        $sameCarReview = $this->em->getRepository(CarReview::class)->findSameCarReview($this->instance->getStartDate(), $this->instance->getVehicle()->getVehicleId());
        if($sameCarReview == null) return true;
        $this->errors .= 'Esiste già una revisione per questo veicolo in questo lasso di tempo<br>';
        return false;
    }
}