<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="insurances")
 */
class Insurance extends VehiclePeriodicCost
{
    /**
     * @ORM\ManyToOne(targetEntity="Provider")
     * @ORM\JoinColumn(name="companyId", referencedColumnName="idProvider")
     */
    private $company;

    /**
     * @ORM\Column(type="string", nullable=false, length=64, name="number")
     * @Assert\NotBlank(message="Insurance Number cannot be null")
     * @Assert\Length(max=64, maxMessage="Insurance Number too long. Max 64 chars")
     */
    private $number;

    /**
     * @ORM\Column(type="string", nullable=true, length=128, name="agent")
     */
    private $agent;

    /**
     * @ORM\Column(type="int", nullable=false, length=1, name="durationType")
     * @Assert\NotBlank(message="Insurance Duration Type cannot be null")
     */
    private $durationType;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true, name="flat")
     */
    private $flat;
}