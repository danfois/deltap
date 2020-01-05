<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="course_attendances")
 */
class CourseAttendance
{
    /**
     * @ORM\Column(type="integer", length=11, name="attendanceId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $attendanceId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Course", inversedBy="attendances", cascade={"persist"})
     * @ORM\JoinColumn(name="courseId", referencedColumnName="courseId")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Employee", inversedBy="attendances", cascade={"persist"})
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    private $employee;

    /**
     * Get attendanceId.
     *
     * @return int
     */
    public function getAttendanceId()
    {
        return $this->attendanceId;
    }

    /**
     * Set course.
     *
     * @param \AppBundle\Entity\Employee\Course|null $course
     *
     * @return CourseAttendance
     */
    public function setCourse(\AppBundle\Entity\Employee\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course.
     *
     * @return \AppBundle\Entity\Employee\Course|null
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set employee.
     *
     * @param \AppBundle\Entity\Employee\Employee|null $employee
     *
     * @return CourseAttendance
     */
    public function setEmployee(\AppBundle\Entity\Employee\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee.
     *
     * @return \AppBundle\Entity\Employee\Employee|null
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}
