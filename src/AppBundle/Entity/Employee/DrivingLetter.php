<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DrivingLetterRepository")
 * @ORM\Table(name="driving_letters")
 */
class DrivingLetter extends DrivingDocument
{
    /**
     * @ORM\Column(type="integer", name="letterId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $letterId;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="drivingLetters")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="drivingLetter")
     */
    private $documents;
}