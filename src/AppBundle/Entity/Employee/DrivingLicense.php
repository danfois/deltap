<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DrivingLicenseRepository")
 * @ORM\Table(name="driving_licenses")
 */
class DrivingLicense extends DrivingDocument
{
    /**
     * @ORM\Column(type="integer", name="idCustomer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $licenseId;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="drivingLicense")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    private $employee;

    /**
     * @ORM\Column(type="string", length=4, nullable=false, name="type")
     * @Assert\NotBlank(message="Driving License kind must not be null")
     * @Assert\Length(max=4, maxMessage="Driving License Type is too long. Max 4 chars.")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="drivingLicense")
     */
    private $documents;

}