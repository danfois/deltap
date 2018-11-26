<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeTurnDetailRepository")
 * @ORM\Table(name="turn_details")
 */
class EmployeeTurnDetail
{
    /**
     * @ORM\Column(type="integer", name="turnDetailId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $turnDetailId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\EmployeeTurn", inversedBy="turnDetails")
     * @ORM\JoinColumn(name="turnId", referencedColumnName="turnId")
     */
    protected $turn;

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
     * @ORM\Column(type="boolean", nullable=false, name="illness")
     */
    protected $illness;

    /**
     * @ORM\Column(type="boolean", nullable=false, name="holiday")
     */
    protected $holiday;

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
     * Get turnDetailId
     *
     * @return integer
     */
    public function getTurnDetailId()
    {
        return $this->turnDetailId;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return EmployeeTurnDetail
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
     * @return EmployeeTurnDetail
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
     * @return EmployeeTurnDetail
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
     * Set illness
     *
     * @param boolean $illness
     *
     * @return EmployeeTurnDetail
     */
    public function setIllness($illness)
    {
        $this->illness = $illness;

        return $this;
    }

    /**
     * Get illness
     *
     * @return boolean
     */
    public function getIllness()
    {
        return $this->illness;
    }

    /**
     * Set holiday
     *
     * @param boolean $holiday
     *
     * @return EmployeeTurnDetail
     */
    public function setHoliday($holiday)
    {
        $this->holiday = $holiday;

        return $this;
    }

    /**
     * Get holiday
     *
     * @return boolean
     */
    public function getHoliday()
    {
        return $this->holiday;
    }

    /**
     * Set permissionTime
     *
     * @param \DateTime $permissionTime
     *
     * @return EmployeeTurnDetail
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
     * Set turn
     *
     * @param \AppBundle\Entity\Employee\EmployeeTurn $turn
     *
     * @return EmployeeTurnDetail
     */
    public function setTurn(\AppBundle\Entity\Employee\EmployeeTurn $turn = null)
    {
        $this->turn = $turn;

        return $this;
    }

    /**
     * Get turn
     *
     * @return \AppBundle\Entity\Employee\EmployeeTurn
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return EmployeeTurnDetail
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
     * @return EmployeeTurnDetail
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
