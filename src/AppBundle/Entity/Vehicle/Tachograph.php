<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tachographs")
 */
class Tachograph
{
    /**
     * @ORM\Column(type="integer", name="tachographId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $tachographId;

    /**
     * @ORM\ManyToOne(targetEntity="Vehicle", inversedBy="tachographs")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    private $vehicle;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="startKm")
     * @Assert\NotBlank(message="Start Km cannot be null")
     */
    private $startKm;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="endKm")
     * @Assert\NotBlank(message="End Km cannot be null")
     */
    private $endKm;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="date")
     * @Assert\NotBlank(message="Date cannot be null")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="expiration")
     * @Assert\NotBlank(message="Expiration Date cannot be null")
     */
    private $expiration;

    /**
     * Set startKm
     *
     * @param string $startKm
     *
     * @return Tachograph
     */
    public function setStartKm($startKm)
    {
        $this->startKm = $startKm;

        return $this;
    }

    /**
     * Get startKm
     *
     * @return string
     */
    public function getStartKm()
    {
        return $this->startKm;
    }

    /**
     * Set endKm
     *
     * @param string $endKm
     *
     * @return Tachograph
     */
    public function setEndKm($endKm)
    {
        $this->endKm = $endKm;

        return $this;
    }

    /**
     * Get endKm
     *
     * @return string
     */
    public function getEndKm()
    {
        return $this->endKm;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tachograph
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set expiration
     *
     * @param \DateTime $expiration
     *
     * @return Tachograph
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle $vehicle
     *
     * @return Tachograph
     */
    public function setVehicle(\AppBundle\Entity\Vehicle\Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \AppBundle\Entity\Vehicle\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Get tachographId
     *
     * @return integer
     */
    public function getTachographId()
    {
        return $this->tachographId;
    }
}
