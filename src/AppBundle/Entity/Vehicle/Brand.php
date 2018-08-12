<?php

namespace AppBundle\Entity\Vehicle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="brands")
 */
class Brand
{
    /**
     * @ORM\Column(type="integer", name="brandId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $brandId;

    /**
     * @ORM\Column(type="string", length=55, nullable=false, name="code")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=55, nullable=false, name="title")
     */
    private $title;

    /**
     * Get brandId
     *
     * @return integer
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Brand
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Brand
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
