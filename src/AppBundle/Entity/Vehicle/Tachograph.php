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
     * @ORM\ManyToOne(targetEntity="Vehicle")
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
}