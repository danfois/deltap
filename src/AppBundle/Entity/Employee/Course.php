<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 * @ORM\Table(name="courses")
 */
class Course
{
    /**
     * @ORM\Column(type="integer", length=4, name="courseId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $courseId;

    /**
     * @ORM\Column(type="string", length=180, name="name")
     * @Assert\NotBlank(message="Devi inserire il nome del corso")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee\CourseAttendance", mappedBy="course")
     */
    protected $attendances;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attendances = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get courseId.
     *
     * @return int
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add attendance.
     *
     * @param \AppBundle\Entity\Employee\CourseAttendance $attendance
     *
     * @return Course
     */
    public function addAttendance(\AppBundle\Entity\Employee\CourseAttendance $attendance)
    {
        $this->attendances[] = $attendance;

        return $this;
    }

    /**
     * Remove attendance.
     *
     * @param \AppBundle\Entity\Employee\CourseAttendance $attendance
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAttendance(\AppBundle\Entity\Employee\CourseAttendance $attendance)
    {
        return $this->attendances->removeElement($attendance);
    }

    /**
     * Get attendances.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttendances()
    {
        return $this->attendances;
    }
}
