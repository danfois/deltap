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
     * @ORM\Column(type="string", length=11, nullable=false, name="employeeId")
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
     * @ORM\Column(type="text, nullable=true, name="duties")
     */
    private $duties;

    /**
     * @ORM\OneToMany(targetEntity="Curriculum", mappedBy="employee")
     */
    private $curriculums;

    /**
     * @ORM\OneToMany(targetEntity="DrivingLicense", mappedBy="employee")
     */
    private $drivingLicenses;

    /**
     * @ORM\OneToMany(targetEntity="DrivingLetter", mappedBy="employee")
     */
    private $drivingLetters;

    /**
     * @ORM\OneToMany(targetEntity="DriverQualificationLetter", mappedBy="employee")
     */
    private $driverQualificationLetters;

}