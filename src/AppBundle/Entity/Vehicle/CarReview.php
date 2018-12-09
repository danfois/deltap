<?php

namespace AppBundle\Entity\Vehicle;
use AppBundle\Entity\Invoice\InvoiceDetailInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarReviewRepository")
 * @ORM\Table(name="carReview")
 */
class CarReview extends VehiclePeriodicCost implements UnavailabilityInterface, InvoiceDetailInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Vehicle", inversedBy="carReviews")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    private $vehicle;

    /**
     * @ORM\Column(type="integer", name="carReviewId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $carReviewId;

    /**
     * Get carReviewId
     *
     * @return integer
     */
    public function getCarReviewId()
    {
        return $this->carReviewId;
    }

    public function getIssue()
    {
        return 'Revisione Scaduta';
    }

    public function getVehicle()
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function getProductCode(): string
    {
        return '';
    }

    public function getProductName(): string
    {
        return 'Revisione per il veicolo ' . $this->getVehicle()->getPlate();
    }

    public function getInvoicePrice(): float
    {
        return $this->getPrice();
    }

    public function getInvoiceVat()
    {
        return 22;
    }

    public function getInvoiceCustomer()
    {
        return null;
    }
}
