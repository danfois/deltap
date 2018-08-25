<?php

namespace AppBundle\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="curriculums")
 */
class Curriculum
{
    /**
     * @ORM\Column(type="string", length=11, nullable=false, name="curriculumId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $curriculumId;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="curriculums")
     * @ORM\JoinColumn(name="employeeId", referencedColumnName="employeeId")
     */
    private $employee;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, name="qualification")
     * @Assert\NotBlank(message="Qualification must not be null")
     * @Assert\Length(max=64, maxMessage="Qualification is too long. Max 64 chars.")
     */
    private $qualification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="languages")
     */
    private $languages;

    /**
     * @ORM\Column(type="text", nullable=true, name="workExperience")
     */
    private $workExperience;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="Curriculum")
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
     * Get curriculumId
     *
     * @return string
     */
    public function getCurriculumId()
    {
        return $this->curriculumId;
    }

    /**
     * Set qualification
     *
     * @param string $qualification
     *
     * @return Curriculum
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set languages
     *
     * @param string $languages
     *
     * @return Curriculum
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * Get languages
     *
     * @return string
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set workExperience
     *
     * @param string $workExperience
     *
     * @return Curriculum
     */
    public function setWorkExperience($workExperience)
    {
        $this->workExperience = $workExperience;

        return $this;
    }

    /**
     * Get workExperience
     *
     * @return string
     */
    public function getWorkExperience()
    {
        return $this->workExperience;
    }

    /**
     * Add document
     *
     * @param \AppBundle\Entity\Employee\Document $document
     *
     * @return Curriculum
     */
    public function addDocument(\AppBundle\Entity\Employee\Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \AppBundle\Entity\Employee\Document $document
     */
    public function removeDocument(\AppBundle\Entity\Employee\Document $document)
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

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     *
     * @return Curriculum
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
}
