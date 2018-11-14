<?php

namespace AppBundle\Entity\PriceQuotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandRepository")
 * @ORM\Table(name="demands")
 */
class Demand
{
    /**
     * @ORM\Column(type="integer", name="demandId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $demandId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PriceQuotation\PriceQuotation")
     * @ORM\JoinColumn(name="priceQuotationId", referencedColumnName="priceQuotationId", nullable=true)
     */
    protected $priceQuotation;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="demandDateTime")
     * @Assert\NotBlank(message="Demand Date and Time cannot be null")
     */
    protected $demandDateTime;

    /**
     * @ORM\Column(type="string", nullable=false, name="requestedBy")
     * @Assert\NotBlank(message="Requested By field cannot be null")
     */
    protected $requestedBy;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id_user")
     */
    protected $receiver;

    /**
     * @ORM\Column(type="text", nullable=false, name="subject")
     * @Assert\NotBlank(message="Demand Subject cannot be nulL")
     */
    protected $subject;

    /**
     * @ORM\Column(type="integer", nullable=false, length=1, name="demandType")
     * @Assert\NotBlank(message="Demand type cannot be null")
     */
    protected $demandType;

    /**
     * Get demandId
     *
     * @return integer
     */
    public function getDemandId()
    {
        return $this->demandId;
    }

    /**
     * Set demandDateTime
     *
     * @param \DateTime $demandDateTime
     *
     * @return Demand
     */
    public function setDemandDateTime($demandDateTime)
    {
        $this->demandDateTime = $demandDateTime;

        return $this;
    }

    /**
     * Get demandDateTime
     *
     * @return \DateTime
     */
    public function getDemandDateTime()
    {
        return $this->demandDateTime;
    }

    /**
     * Set requestedBy
     *
     * @param string $requestedBy
     *
     * @return Demand
     */
    public function setRequestedBy($requestedBy)
    {
        $this->requestedBy = $requestedBy;

        return $this;
    }

    /**
     * Get requestedBy
     *
     * @return string
     */
    public function getRequestedBy()
    {
        return $this->requestedBy;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Demand
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set demandType
     *
     * @param integer $demandType
     *
     * @return Demand
     */
    public function setDemandType($demandType)
    {
        $this->demandType = $demandType;

        return $this;
    }

    /**
     * Get demandType
     *
     * @return integer
     */
    public function getDemandType()
    {
        return $this->demandType;
    }

    /**
     * Set priceQuotation
     *
     * @param \AppBundle\Entity\PriceQuotation\PriceQuotation $priceQuotation
     *
     * @return Demand
     */
    public function setPriceQuotation(\AppBundle\Entity\PriceQuotation\PriceQuotation $priceQuotation = null)
    {
        $this->priceQuotation = $priceQuotation;

        return $this;
    }

    /**
     * Get priceQuotation
     *
     * @return \AppBundle\Entity\PriceQuotation\PriceQuotation
     */
    public function getPriceQuotation()
    {
        return $this->priceQuotation;
    }

    /**
     * Set receiver
     *
     * @param \AppBundle\Entity\User $receiver
     *
     * @return Demand
     */
    public function setReceiver(\AppBundle\Entity\User $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \AppBundle\Entity\User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
