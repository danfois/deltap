<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="documents")
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="documentId")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $documentId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\Curriculum", inversedBy="documents")
     * @ORM\JoinColumn(name="curriculumId", referencedColumnName="curriculumId", nullable=true)
     */
    public $curriculum;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\DrivingLicense", inversedBy="documents")
     * @ORM\JoinColumn(name="licenseId", referencedColumnName="licenseId", nullable=true)
     */
    public $drivingLicense;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\DrivingLetter", inversedBy="documents")
     * @ORM\JoinColumn(name="letterId", referencedColumnName="letterId", nullable=true)
     */
    public $drivingLetter;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee\DriverQualificationLetter", inversedBy="documents")
     * @ORM\JoinColumn(name="qualificationId", referencedColumnName="qualificationId", nullable=true)
     */
    public $driverQualificationLetter;


    /**
     * @Assert\File(maxSize="60000000")
     */
    private $file;

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            throw new \Exception('Files nullo');
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getName();

        // clean up the file property as you won't need it anymore
        //$this->file = null;
    }

    /**
     * Get documentId
     *
     * @return integer
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set curriculum
     *
     * @param \AppBundle\Entity\Employee\Curriculum $curriculum
     *
     * @return Document
     */
    public function setCurriculum(\AppBundle\Entity\Employee\Curriculum $curriculum = null)
    {
        $this->curriculum = $curriculum;

        return $this;
    }

    /**
     * Get curriculum
     *
     * @return \AppBundle\Entity\Employee\Curriculum
     */
    public function getCurriculum()
    {
        return $this->curriculum;
    }

    /**
     * Set drivingLicense
     *
     * @param \AppBundle\Entity\Employee\DrivingLicense $drivingLicense
     *
     * @return Document
     */
    public function setDrivingLicense(\AppBundle\Entity\Employee\DrivingLicense $drivingLicense = null)
    {
        $this->drivingLicense = $drivingLicense;

        return $this;
    }

    /**
     * Get drivingLicense
     *
     * @return \AppBundle\Entity\Employee\DrivingLicense
     */
    public function getDrivingLicense()
    {
        return $this->drivingLicense;
    }

    /**
     * Set drivingLetter
     *
     * @param \AppBundle\Entity\Employee\DrivingLetter $drivingLetter
     *
     * @return Document
     */
    public function setDrivingLetter(\AppBundle\Entity\Employee\DrivingLetter $drivingLetter = null)
    {
        $this->drivingLetter = $drivingLetter;

        return $this;
    }

    /**
     * Get drivingLetter
     *
     * @return \AppBundle\Entity\Employee\DrivingLetter
     */
    public function getDrivingLetter()
    {
        return $this->drivingLetter;
    }

    /**
     * Set driverQualificationLetter
     *
     * @param \AppBundle\Entity\Employee\DriverQualificationLetter $driverQualificationLetter
     *
     * @return Document
     */
    public function setDriverQualificationLetter(\AppBundle\Entity\Employee\DriverQualificationLetter $driverQualificationLetter = null)
    {
        $this->driverQualificationLetter = $driverQualificationLetter;

        return $this;
    }

    /**
     * Get driverQualificationLetter
     *
     * @return \AppBundle\Entity\Employee\DriverQualificationLetter
     */
    public function getDriverQualificationLetter()
    {
        return $this->driverQualificationLetter;
    }
}
