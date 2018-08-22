<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\CarReview;
use AppBundle\Entity\Vehicle\CarTax;
use AppBundle\Entity\Vehicle\Insurance;
use AppBundle\Entity\Vehicle\InsuranceSuspension;
use AppBundle\Entity\Vehicle\Unavailability;
use AppBundle\Entity\Vehicle\UnavailabilityInterface;
use Doctrine\ORM\EntityManager;

class UnavailabilityCreator
{
    protected $em;
    protected $id;
    protected $type;
    protected $instance;
    protected $errors;
    protected $unavailability;

    public function __construct(int $id, string $type, EntityManager $em)
    {
        $this->id = $id;
        $this->type = $type;
        $this->em = $em;
    }

    public function create()
    {
        $this->checkType();
        $this->prepareUnavailability();
    }

    protected function checkType()
    {
        try {
            switch ($this->type) {
                case 'suspension':
                    $this->setInstance($this->em->getRepository(InsuranceSuspension::class)->findOneBy(array('suspensionId' => $this->id)));
                    break;
                case 'cartax':
                    $this->setInstance($this->em->getRepository(CarTax::class)->findOneBy(array('carTaxId' => $this->id)));
                    break;
                case 'carreview':
                    $this->setInstance($this->em->getRepository(CarReview::class)->findOneBy(array('carReviewId' => $this->id)));
                    break;
            }
        } catch( \Exception $e) {
            $this->errors .= 'Errore durante il fetch della classe<br>';
        }
    }

    protected function setInstance(UnavailabilityInterface $instance)
    {
        $this->instance = $instance;
    }

    protected function prepareUnavailability()
    {
        $u = new Unavailability();
        $u->setVehicle($this->instance->getVehicle());
        $u->setStartDate($this->instance->getStartDate());
        $u->setEndDate($this->instance->getEndDate());
        $u->setIssue($this->instance->getIssue());

        $this->unavailability = $u;
    }

    public function getUnavailability()
    {
        return $this->unavailability;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}