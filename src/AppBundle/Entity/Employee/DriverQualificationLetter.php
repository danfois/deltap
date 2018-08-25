<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriverQualificationLetterRepository")
 * @ORM\Table(name="driver_qualification_letters")
 */
class DriverQualificationLetter extends DrivingDocument
{
    /**
     * @ORM\Column(type="integer", name="qualificationId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $qualificationId;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="driverQualificationLetters")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="driverQualificationLetter")
     */
    private $documents;
}