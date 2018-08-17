<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarReviewRepository")
 * @ORM\Table(name="carReview")
 */
class CarReview extends VehiclePeriodicCost
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

    public function getVehicle()
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }
}
