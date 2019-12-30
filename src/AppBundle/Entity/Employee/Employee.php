<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Contactable;
use AppBundle\Entity\Person;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 * @ORM\Table(name="employees")
 */
class Employee extends Person
{
    /**
     * @ORM\Column(type="integer", length=11, name="employeeId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $employeeId;

    /**
     * @ORM\Column(type="string", length=11, nullable=true, name="employeeCode")
     * @Assert\Length(max=11, maxMessage="Employee Code too long. Max 11 chars")
     */
    private $employeeCode;

    /**
     * @ORM\Column(type="string", length=24, nullable=false, name="employmentType")
     * @Assert\NotBlank(message="Employment Type cannot be null")
     */
    private $employmentType;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="admission")
     * @Assert\NotBlank(message="Admission date cannot be null.")
     */
    private $admission;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="payGrade")
     * @Assert\NotBlank(message="Pay Grade cannot be null")
     * @Assert\Length(max=64, maxMessage="Pay grade is too long. Max 64 chars")
     */
    private $payGrade;

    /**
     * @ORM\Column(type="text", nullable=true, name="duties")
     */
    private $duties;

    /**
     * @ORM\OneToMany(targetEntity="Curriculum", mappedBy="employee")
     */
    private $curriculums;

    /**
     * @ORM\OneToMany(targetEntity="DrivingLicense", mappedBy="employee")
     * @ORM\OrderBy({"expiration" = "ASC"})
     */
    private $drivingLicenses;

    /**
     * @ORM\OneToMany(targetEntity="DrivingLetter", mappedBy="employee")
     * @ORM\OrderBy({"expiration" = "ASC"})
     */
    private $drivingLetters;

    /**
     * @ORM\OneToMany(targetEntity="DriverQualificationLetter", mappedBy="employee")
     * @ORM\OrderBy({"expiration" = "ASC"})
     */
    private $driverQualificationLetters;

    /**
     * @ORM\Column(type="integer", length=1, nullable=false, name="is_fired")
     */
    private $isFired;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="termination_date")
     */
    private $terminationDate;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee\EmployeeUnavailability", mappedBy="employee")
     */
    private $unavailabilities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->curriculums = new \Doctrine\Common\Collections\ArrayCollection();
        $this->drivingLicenses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->drivingLetters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->driverQualificationLetters = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get employeeId
     *
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
        return $this;
    }

    /**
     * Set employeeCode
     *
     * @param string $employeeCode
     *
     * @return Employee
     */
    public function setEmployeeCode($employeeCode)
    {
        $this->employeeCode = $employeeCode;

        return $this;
    }

    /**
     * Get employeeCode
     *
     * @return string
     */
    public function getEmployeeCode()
    {
        return $this->employeeCode;
    }

    /**
     * Set employmentType
     *
     * @param string $employmentType
     *
     * @return Employee
     */
    public function setEmploymentType($employmentType)
    {
        $this->employmentType = $employmentType;

        return $this;
    }

    /**
     * Get employmentType
     *
     * @return string
     */
    public function getEmploymentType()
    {
        return $this->employmentType;
    }

    /**
     * Set admission
     *
     * @param \DateTime $admission
     *
     * @return Employee
     */
    public function setAdmission($admission)
    {
        $this->admission = $admission;

        return $this;
    }

    /**
     * Get admission
     *
     * @return \DateTime
     */
    public function getAdmission()
    {
        return $this->admission;
    }

    /**
     * Set payGrade
     *
     * @param string $payGrade
     *
     * @return Employee
     */
    public function setPayGrade($payGrade)
    {
        $this->payGrade = $payGrade;

        return $this;
    }

    /**
     * Get payGrade
     *
     * @return string
     */
    public function getPayGrade()
    {
        return $this->payGrade;
    }

    /**
     * Set duties
     *
     * @param string $duties
     *
     * @return Employee
     */
    public function setDuties($duties)
    {
        $this->duties = $duties;

        return $this;
    }

    /**
     * Get duties
     *
     * @return string
     */
    public function getDuties()
    {
        return $this->duties;
    }

    /**
     * Add curriculum
     *
     * @param \AppBundle\Entity\Employee\Curriculum $curriculum
     *
     * @return Employee
     */
    public function addCurriculum(\AppBundle\Entity\Employee\Curriculum $curriculum)
    {
        $this->curriculums[] = $curriculum;

        return $this;
    }

    /**
     * Remove curriculum
     *
     * @param \AppBundle\Entity\Employee\Curriculum $curriculum
     */
    public function removeCurriculum(\AppBundle\Entity\Employee\Curriculum $curriculum)
    {
        $this->curriculums->removeElement($curriculum);
    }

    /**
     * Get curriculums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCurriculums()
    {
        return $this->curriculums;
    }

    /**
     * Add drivingLicense
     *
     * @param \AppBundle\Entity\Employee\DrivingLicense $drivingLicense
     *
     * @return Employee
     */
    public function addDrivingLicense(\AppBundle\Entity\Employee\DrivingLicense $drivingLicense)
    {
        $this->drivingLicenses[] = $drivingLicense;

        return $this;
    }

    /**
     * Remove drivingLicense
     *
     * @param \AppBundle\Entity\Employee\DrivingLicense $drivingLicense
     */
    public function removeDrivingLicense(\AppBundle\Entity\Employee\DrivingLicense $drivingLicense)
    {
        $this->drivingLicenses->removeElement($drivingLicense);
    }

    /**
     * Get drivingLicenses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDrivingLicenses()
    {
        return $this->drivingLicenses;
    }

    /**
     * Add drivingLetter
     *
     * @param \AppBundle\Entity\Employee\DrivingLetter $drivingLetter
     *
     * @return Employee
     */
    public function addDrivingLetter(\AppBundle\Entity\Employee\DrivingLetter $drivingLetter)
    {
        $this->drivingLetters[] = $drivingLetter;

        return $this;
    }

    /**
     * Remove drivingLetter
     *
     * @param \AppBundle\Entity\Employee\DrivingLetter $drivingLetter
     */
    public function removeDrivingLetter(\AppBundle\Entity\Employee\DrivingLetter $drivingLetter)
    {
        $this->drivingLetters->removeElement($drivingLetter);
    }

    /**
     * Get drivingLetters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDrivingLetters()
    {
        return $this->drivingLetters;
    }

    /**
     * Add driverQualificationLetter
     *
     * @param \AppBundle\Entity\Employee\DriverQualificationLetter $driverQualificationLetter
     *
     * @return Employee
     */
    public function addDriverQualificationLetter(\AppBundle\Entity\Employee\DriverQualificationLetter $driverQualificationLetter)
    {
        $this->driverQualificationLetters[] = $driverQualificationLetter;

        return $this;
    }

    /**
     * Remove driverQualificationLetter
     *
     * @param \AppBundle\Entity\Employee\DriverQualificationLetter $driverQualificationLetter
     */
    public function removeDriverQualificationLetter(\AppBundle\Entity\Employee\DriverQualificationLetter $driverQualificationLetter)
    {
        $this->driverQualificationLetters->removeElement($driverQualificationLetter);
    }

    /**
     * Get driverQualificationLetters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDriverQualificationLetters()
    {
        return $this->driverQualificationLetters;
    }

    /**
     * Set isFired
     *
     * @param integer $isFired
     *
     * @return Employee
     */
    public function setIsFired($isFired)
    {
        $this->isFired = $isFired;

        return $this;
    }

    /**
     * Get isFired
     *
     * @return integer
     */
    public function getIsFired()
    {
        return $this->isFired;
    }

    /**
     * Set terminationDate
     *
     * @param \DateTime $terminationDate
     *
     * @return Employee
     */
    public function setTerminationDate($terminationDate)
    {
        $this->terminationDate = $terminationDate;

        return $this;
    }

    /**
     * Get terminationDate
     *
     * @return \DateTime
     */
    public function getTerminationDate()
    {
        return $this->terminationDate;
    }

    /**
     * Add unavailability
     *
     * @param \AppBundle\Entity\Employee\EmployeeUnavailability $unavailability
     *
     * @return Employee
     */
    public function addUnavailability(\AppBundle\Entity\Employee\EmployeeUnavailability $unavailability)
    {
        $this->unavailabilities[] = $unavailability;

        return $this;
    }

    /**
     * Remove unavailability
     *
     * @param \AppBundle\Entity\Employee\EmployeeUnavailability $unavailability
     */
    public function removeUnavailability(\AppBundle\Entity\Employee\EmployeeUnavailability $unavailability)
    {
        $this->unavailabilities->removeElement($unavailability);
    }

    /**
     * Get unavailabilities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnavailabilities()
    {
        return $this->unavailabilities;
    }
}
