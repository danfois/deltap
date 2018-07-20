<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="places")
 */
class Place
{
    /**
     * @ORM\Column(type="string", length=5, nullable=false, name="istat")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $istat;

    /**
     * @ORM\Column(type="string", length=160, nullable=false, name="comune")
     */
    private $comune;

    /**
     * @ORM\Column(type="string", nullable=false, name="regione", length=32)
     */
    private $regione;

    /**
     * @ORM\Column(type="string", nullable=false, name="provincia", length=2)
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", nullable=false, name="cap", length=6)
     */
    private $cap;

    /**
     * Set istat
     *
     * @param string $istat
     *
     * @return Place
     */
    public function setIstat($istat)
    {
        $this->istat = $istat;

        return $this;
    }

    /**
     * Get istat
     *
     * @return string
     */
    public function getIstat()
    {
        return $this->istat;
    }

    /**
     * Set comune
     *
     * @param string $comune
     *
     * @return Place
     */
    public function setComune($comune)
    {
        $this->comune = $comune;

        return $this;
    }

    /**
     * Get comune
     *
     * @return string
     */
    public function getComune()
    {
        return $this->comune;
    }

    /**
     * Set regione
     *
     * @param string $regione
     *
     * @return Place
     */
    public function setRegione($regione)
    {
        $this->regione = $regione;

        return $this;
    }

    /**
     * Get regione
     *
     * @return string
     */
    public function getRegione()
    {
        return $this->regione;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Place
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set cap
     *
     * @param string $cap
     *
     * @return Place
     */
    public function setCap($cap)
    {
        $this->cap = $cap;

        return $this;
    }

    /**
     * Get cap
     *
     * @return string
     */
    public function getCap()
    {
        return $this->cap;
    }
}
