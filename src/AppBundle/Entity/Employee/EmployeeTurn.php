<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeTurnRepository")
 * @ORM\Table(name="turns")
 */
class EmployeeTurn
{
    /**
     * @ORM\Column(type="integer", name="turnId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $turnId;

    /**
     * @ORM\Column(type="date", nullable=false, name="turnDate")
     */
    protected $turnDate;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee\EmployeeTurnDetail", mappedBy="turn")
     */
    protected $turnDetails;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->turnDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get turnId
     *
     * @return integer
     */
    public function getTurnId()
    {
        return $this->turnId;
    }

    /**
     * Set turnDate
     *
     * @param \DateTime $turnDate
     *
     * @return EmployeeTurn
     */
    public function setTurnDate($turnDate)
    {
        $this->turnDate = $turnDate;

        return $this;
    }

    /**
     * Get turnDate
     *
     * @return \DateTime
     */
    public function getTurnDate()
    {
        return $this->turnDate;
    }

    /**
     * Add turnDetail
     *
     * @param \AppBundle\Entity\Employee\EmployeeTurnDetail $turnDetail
     *
     * @return EmployeeTurn
     */
    public function addTurnDetail(\AppBundle\Entity\Employee\EmployeeTurnDetail $turnDetail)
    {
        $this->turnDetails[] = $turnDetail;

        return $this;
    }

    /**
     * Remove turnDetail
     *
     * @param \AppBundle\Entity\Employee\EmployeeTurnDetail $turnDetail
     */
    public function removeTurnDetail(\AppBundle\Entity\Employee\EmployeeTurnDetail $turnDetail)
    {
        $this->turnDetails->removeElement($turnDetail);
    }

    /**
     * Get turnDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTurnDetails()
    {
        return $this->turnDetails;
    }
}
