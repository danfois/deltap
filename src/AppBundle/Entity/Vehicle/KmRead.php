<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="km_read")
 */
class KmRead
{
    /**
     * @ORM\Column(type="integer", name="readId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $readId;

    /**
     * @ORM\ManyToOne(targetEntity="Vehicle", inversedBy="kmReads")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    private $vehicle;

    /**
     * @ORM\Column(type="datetime", name="read_date", nullable=false)
     * @Assert\NotBlank(message="Read date must not be null")
     */
    private $readDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, name="km")
     * @Assert\NotBlank(message="Kilometers must not be null")
     */
    private $km;

    //todo: abbinare agli ordini di servizio
    /**
     * @ORM\Column(type="integer", name="service_order", nullable=true)
     */
    private $serviceOrder;

    /**
     * Get readId
     *
     * @return integer
     */
    public function getReadId()
    {
        return $this->readId;
    }

    /**
     * Set readDate
     *
     * @param \DateTime $readDate
     *
     * @return KmRead
     */
    public function setReadDate($readDate)
    {
        $this->readDate = $readDate;

        return $this;
    }

    /**
     * Get readDate
     *
     * @return \DateTime
     */
    public function getReadDate()
    {
        return $this->readDate;
    }

    /**
     * Set km
     *
     * @param string $km
     *
     * @return KmRead
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return string
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set serviceOrder
     *
     * @param integer $serviceOrder
     *
     * @return KmRead
     */
    public function setServiceOrder($serviceOrder)
    {
        $this->serviceOrder = $serviceOrder;

        return $this;
    }

    /**
     * Get serviceOrder
     *
     * @return integer
     */
    public function getServiceOrder()
    {
        return $this->serviceOrder;
    }

    /**
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle $vehicle
     *
     * @return KmRead
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
}
