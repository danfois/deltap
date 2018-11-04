<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="employee_unavailabilities")
 */
class EmployeeUnavailability
{
    /**
     * @ORM\Column(type="integer", length=11, name="unavailabilityId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $unavailabilityId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Employee", inversedBy="unavailabilities")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    protected $employee;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="startDate")
     * @Assert\NotBlank(message="Employee Unavailability start date must not be null")
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="endDate")
     */
    protected $endDate;

    /**
     * @ORM\Column(type="string", nullable=false, name="issue")
     * @Assert\NotBlank(message="Issue must not be null")
     */
    protected $issue;


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
     * @return EmployeeUnavailability
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
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return EmployeeUnavailability
     */
    public function setEndDate($endTime)
    {
        $this->endDate = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return EmployeeUnavailability
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
     * Set issue
     *
     * @param string $issue
     *
     * @return EmployeeUnavailability
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
}
