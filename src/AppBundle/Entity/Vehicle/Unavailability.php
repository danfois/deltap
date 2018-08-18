<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnavailabilityRepository")
 * @ORM\Table(name="unavailabilities")
 */
class Unavailability
{
    /**
     * @ORM\Column(type="integer", name="unavailabilityId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $unavailabilityId;

    /**
     * @ORM\ManyToOne(targetEntity="Vehicle", inversedBy="unavailabilities")
     * @ORM\JoinColumn(name="vehicleId", referencedColumnName="vehicleId")
     */
    private $vehicle;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="startDate")
     * @Assert\NotBlank(message="Unavailability Start Date cannot be null")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="endDate")
     * @Assert\NotBlank(message="Unavailability End Date cannot be null")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=128, name="issue", nullable=false)
     * @Assert\NotBlank(message="Unavailability issue must not be null")
     * @Assert\Length(max=128, maxMessage="Unavailability issue too long. Max 128 chars")
     */
    private $issue;

    /**
     * Get unavailabilityId
     *
     * @return integer
     */
    public function getUnavailabilityId()
    {
        return $this->unavailabilityId;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Unavailability
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Unavailability
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set issue
     *
     * @param string $issue
     *
     * @return Unavailability
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;

        return $this;
    }

    /**
     * Get issue
     *
     * @return string
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle\Vehicle $vehicle
     *
     * @return Unavailability
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
