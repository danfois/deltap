<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpirationRepository")
 * @ORM\Table(name="expirations")
 */
class Expiration
{
    /**
     * @ORM\Column(type="integer", name="expirationId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $expirationId;

    /**
     * @ORM\Column(type="string", nullable=false, name="title")
     * @Assert\NotBlank(message="You must provide a valid title to the expiration")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true, name="description")
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="expirationDate")
     * @Assert\NotBlank(message="Expiration date must not be empty")
     */
    protected $expirationDate;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="createdAt")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id_user")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice\IssuedInvoice")
     * @ORM\JoinColumn(name="issuedInvoiceId", referencedColumnName="invoiceId", nullable=true)
     */
    protected $issuedInvoice;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice\ReceivedInvoice")
     * @ORM\JoinColumn(name="receivedInvoiceId", referencedColumnName="invoiceId", nullable=true)
     */
    protected $receivedInvoice;

    /**
     * @ORM\Column(type="boolean", nullable=false, name="isResolved")
     */
    protected $isResolved;

    /**
     * Get expirationId.
     *
     * @return int
     */
    public function getExpirationId()
    {
        return $this->expirationId;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Expiration
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Expiration
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set expirationDate.
     *
     * @param \DateTime $expirationDate
     *
     * @return Expiration
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate.
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Expiration
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Expiration
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set issuedInvoice.
     *
     * @param \AppBundle\Entity\Invoice\IssuedInvoice|null $issuedInvoice
     *
     * @return Expiration
     */
    public function setIssuedInvoice(\AppBundle\Entity\Invoice\IssuedInvoice $issuedInvoice = null)
    {
        $this->issuedInvoice = $issuedInvoice;

        return $this;
    }

    /**
     * Get issuedInvoice.
     *
     * @return \AppBundle\Entity\Invoice\IssuedInvoice|null
     */
    public function getIssuedInvoice()
    {
        return $this->issuedInvoice;
    }

    /**
     * Set receivedInvoice.
     *
     * @param \AppBundle\Entity\Invoice\ReceivedInvoice|null $receivedInvoice
     *
     * @return Expiration
     */
    public function setReceivedInvoice(\AppBundle\Entity\Invoice\ReceivedInvoice $receivedInvoice = null)
    {
        $this->receivedInvoice = $receivedInvoice;

        return $this;
    }

    /**
     * Get receivedInvoice.
     *
     * @return \AppBundle\Entity\Invoice\ReceivedInvoice|null
     */
    public function getReceivedInvoice()
    {
        return $this->receivedInvoice;
    }

    /**
     * Set isResolved.
     *
     * @param bool $isResolved
     *
     * @return Expiration
     */
    public function setIsResolved($isResolved)
    {
        $this->isResolved = $isResolved;

        return $this;
    }

    /**
     * Get isResolved.
     *
     * @return bool
     */
    public function getIsResolved()
    {
        return $this->isResolved;
    }
}
