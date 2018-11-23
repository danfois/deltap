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
     * @ORM\Column(type="time", nullable=true, name="startTime")
     */
    protected $startTime;

    /**
     * @ORM\Column(type="time", nullable=true, name="endTime")
     */
    protected $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Employee")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    protected $employee;

    /**
     * @ORM\Column(type="time", nullable=true, name="workingHours")
     */
    protected $workingHours;

    /**
     * @ORM\Column(type="time", nullable=true, name="illnessTime")
     */
    protected $illnessTime;

    /**
     * @ORM\Column(type="time", nullable=true, name="permissionTime")
     */
    protected $permissionTime;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id_user")
     */
    protected $user;

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
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return EmployeeTurn
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return EmployeeTurn
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set workingHours
     *
     * @param \DateTime $workingHours
     *
     * @return EmployeeTurn
     */
    public function setWorkingHours($workingHours)
    {
        $this->workingHours = $workingHours;

        return $this;
    }

    /**
     * Get workingHours
     *
     * @return \DateTime
     */
    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    /**
     * Set illnessTime
     *
     * @param \DateTime $illnessTime
     *
     * @return EmployeeTurn
     */
    public function setIllnessTime($illnessTime)
    {
        $this->illnessTime = $illnessTime;

        return $this;
    }

    /**
     * Get illnessTime
     *
     * @return \DateTime
     */
    public function getIllnessTime()
    {
        return $this->illnessTime;
    }

    /**
     * Set permissionTime
     *
     * @param \DateTime $permissionTime
     *
     * @return EmployeeTurn
     */
    public function setPermissionTime($permissionTime)
    {
        $this->permissionTime = $permissionTime;

        return $this;
    }

    /**
     * Get permissionTime
     *
     * @return \DateTime
     */
    public function getPermissionTime()
    {
        return $this->permissionTime;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return EmployeeTurn
     */
    public function setEmployee(\AppBundle\Entity\Employee\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\Employee\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return EmployeeTurn
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
