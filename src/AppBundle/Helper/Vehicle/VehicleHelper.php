<?php

namespace AppBundle\Helper\Vehicle;

use AppBundle\Entity\Vehicle\Vehicle;
use Doctrine\ORM\EntityManager;

class VehicleHelper
{
    private $vehicle;
    private $errors;
    private $em;
    private $executed = 0;
    private $isEdited;

    public function __construct(Vehicle $vehicle, EntityManager $em, $isEdited = false)
    {
        $this->vehicle = $vehicle;
        $this->em = $em;
        $this->isEdited = $isEdited;
    }

    public function execute()
    {
        $this->checkUniquePlate();
        $this->setCarRegistrationDate();
        $this->setRegistrationCardDate();
        $this->setPurchaseDate();
        $this->setSaleDate();
        $this->setFireExtinguisherExpiration();
        $this->executed = 1;
    }

    private function checkUniquePlate()
    {
        $vehicle = $this->em->getRepository(Vehicle::class)->findOneBy(array('plate' => $this->vehicle->getPlate()));
        if($vehicle == $this->vehicle) return true;
        if($vehicle == '') return true;
        $this->errors .= 'Esiste già un veicolo con quella targa; <br>';
        return false;
    }

    private function setCarRegistrationDate()
    {
        //if ($this->vehicle->setCarRegistrationDate(new \DateTime($this->vehicle->getCarRegistrationDate()))) return true;
        if ($this->vehicle->setCarRegistrationDate(\DateTime::createFromFormat('d/m/Y', $this->vehicle->getCarRegistrationDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di Immatricolazione; <br>';
        return false;
    }

    private function setRegistrationCardDate()
    {
        //if ($this->vehicle->setRegistrationCardDate(new \DateTime($this->vehicle->getRegistrationCardDate()))) return true;
        if ($this->vehicle->setRegistrationCardDate(\DateTime::createFromFormat('d/m/Y', $this->vehicle->getRegistrationCardDate()))) return true;
        $this->errors .= 'Impossibile impostare la data della carta di circolazione; <br>';
        return false;
    }

    private function setPurchaseDate()
    {
        if ($this->vehicle->setPurchaseDate(\DateTime::createFromFormat('d/m/Y', $this->vehicle->getPurchaseDate()))) return true;
        $this->errors .= 'Impossibile impostare la data di acquisto del veicolo; <br>';
        return false;
    }

    private function setSaleDate()
    {
        if($this->vehicle->getSaleDate() != '') {
            //if($this->vehicle->setSaleDate(new \DateTime($this->vehicle->getSaleDate()))) return true;
            if($this->vehicle->setSaleDate(\DateTime::createFromFormat('d/m/Y', $this->vehicle->getSaleDate()))) return true;
            $this->errors .= 'Impossibile impostare la data di vendita del veicolo; <br>';
            return false;
        }
        return true;
    }

    private function setFireExtinguisherExpiration() {
        if($this->vehicle->getFireExtinguisherExpiration() != '') {
            //if($this->vehicle->setFireExtinguisherExpiration(new \DateTime($this->vehicle->getFireExtinguisherExpiration()))) return true;
            if($this->vehicle->setFireExtinguisherExpiration($this->vehicle->getFireExtinguisherExpiration())) return true;
            $this->errors .= 'Impossibile impostare la data di scadenza dell \'estintore; <br>';
            return false;
        }
        return true;
    }

    public function getErrors() {
        if($this->executed == 0) {
            throw new \Exception('La classe non è ancora stata eseguita');
        }
        return $this->errors;
    }
}