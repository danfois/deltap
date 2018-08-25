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
     * @ORM\Column(type="integer", name="licenseId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $licenseId;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="drivingLicenses")
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Document", mappedBy="drivingLicense")
     */
    private $documents;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get licenseId
     *
     * @return integer
     */
    public function getLicenseId()
    {
        return $this->licenseId;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return DrivingLicense
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return DrivingLicense
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
     * Add document
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return DrivingLicense
     */
    public function addDocument(\AppBundle\Entity\Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \AppBundle\Entity\Document $document
     */
    public function removeDocument(\AppBundle\Entity\Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }
}
