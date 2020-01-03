<?php

namespace AppBundle\Entity\Provider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProviderRatingRepository")
 * @ORM\Table(name="providerRatings")
 */
class ProviderRating
{
    /**
     * @ORM\Column(type="integer", length=11, name="ratingId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $ratingId;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Invoice\ReceivedInvoice", inversedBy="rating")
     * @ORM\JoinColumn(name="invoiceId", nullable=false, referencedColumnName="invoiceId")
     */
    protected $invoice;

    /**
     * @ORM\Column(type="integer", nullable=false, name="reliability", length=1)
     * @Assert\NotBlank(message="Devi inserire un punteggio di affidabilità")
     * @Assert\GreaterThanOrEqual(value=0, message="Il punteggio di affidabilità deve essere compreso fra 0 e 3")
     * @Assert\LessThanOrEqual(value=3, message="Il punteggio di affidabilità deve essere compreso fra 0 e 3")
     */
    protected $reliability;

    /**
     * @ORM\Column(type="integer", nullable=false, name="quality", length=1)
     * @Assert\NotBlank(message="Devi inserire un punteggio di qualità")
     * @Assert\GreaterThanOrEqual(value=0, message="Il punteggio di qualità deve essere compreso fra 0 e 3")
     * @Assert\LessThanOrEqual(value=3, message="Il punteggio di qualità deve essere compreso fra 0 e 3")
     */
    protected $quality;

    /**
     * @ORM\Column(type="integer", nullable=false, name="price", length=1)
     * @Assert\NotBlank(message="Devi inserire un punteggio per il prezzo")
     * @Assert\GreaterThanOrEqual(value=0, message="Il punteggio del prezzo deve essere compreso fra 0 e 3")
     * @Assert\LessThanOrEqual(value=3, message="Il punteggio del prezzo deve essere compreso fra 0 e 3")
     */
    protected $price;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="insertionDate")
     */
    protected $insertionDate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="author", referencedColumnName="id_user")
     */
    protected $author;

    /**
     * Get ratingId.
     *
     * @return int
     */
    public function getRatingId()
    {
        return $this->ratingId;
    }

    /**
     * Set reliability.
     *
     * @param int $reliability
     *
     * @return ProviderRating
     */
    public function setReliability($reliability)
    {
        $this->reliability = $reliability;

        return $this;
    }

    /**
     * Get reliability.
     *
     * @return int
     */
    public function getReliability()
    {
        return $this->reliability;
    }

    /**
     * Set quality.
     *
     * @param int $quality
     *
     * @return ProviderRating
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality.
     *
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return ProviderRating
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set insertionDate.
     *
     * @param \DateTime|null $insertionDate
     *
     * @return ProviderRating
     */
    public function setInsertionDate($insertionDate = null)
    {
        $this->insertionDate = $insertionDate;

        return $this;
    }

    /**
     * Get insertionDate.
     *
     * @return \DateTime|null
     */
    public function getInsertionDate()
    {
        return $this->insertionDate;
    }

    /**
     * Set invoice.
     *
     * @param \AppBundle\Entity\Invoice\ReceivedInvoice|null $invoice
     *
     * @return ProviderRating
     */
    public function setInvoice(\AppBundle\Entity\Invoice\ReceivedInvoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice.
     *
     * @return \AppBundle\Entity\Invoice\ReceivedInvoice|null
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set author.
     *
     * @param \AppBundle\Entity\User|null $author
     *
     * @return ProviderRating
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
