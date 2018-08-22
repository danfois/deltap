<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InsuranceSuspensionRepository")
 * @ORM\Table(name="insurance_suspensions")
 */
class InsuranceSuspension
{
    /**
     * @ORM\Column(type="integer", name="suspensionId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $suspensionId;

    /**
     * @ORM\ManyToOne(targetEntity="Insurance", inversedBy="suspensions", cascade={"persist"})
     * @ORM\JoinColumn(name="insuranceId", referencedColumnName="insuranceId")
     */
    private $insurance;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="startDate")
     * @Assert\NotBlank(message="Suspension start date cannot be null")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="endDate")
     * @Assert\NotBlank(message="Suspension end date cannot be null")
     */
    private $endDate;

    /**
     * Get suspensionId
     *
     * @return integer
     */
    public function getSuspensionId()
    {
        return $this->suspensionId;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return InsuranceSuspension
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
     * @return InsuranceSuspension
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
     * Set insurance
     *
     * @param \AppBundle\Entity\Vehicle\Insurance $insurance
     *
     * @return InsuranceSuspension
     */
    public function setInsurance(\AppBundle\Entity\Vehicle\Insurance $insurance = null)
    {
        $this->insurance = $insurance;

        return $this;
    }

    /**
     * Get insurance
     *
     * @return \AppBundle\Entity\Vehicle\Insurance
     */
    public function getInsurance()
    {
        return $this->insurance;
    }
}
