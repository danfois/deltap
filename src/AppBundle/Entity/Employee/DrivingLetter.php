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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Document", mappedBy="drivingLetter")
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
     * Get letterId
     *
     * @return integer
     */
    public function getLetterId()
    {
        return $this->letterId;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return DrivingLetter
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
     * @return DrivingLetter
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
